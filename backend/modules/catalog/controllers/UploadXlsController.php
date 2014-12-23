<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 28.08.14
 * Time: 17:33
 */

namespace backend\modules\catalog\controllers;

use common\helpers\CDirectory;
use common\helpers\CString;
use backend\modules\catalog\models\chunkReadFilter;
use common\modules\catalog\models\Product;
use Yii;

use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use backend\modules\admin\models\AdminUsers;
use yii\web\UploadedFile;

class UploadXlsController extends Controller
{

    public function behaviors()
    {
        return [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['post'],
//                ],
//            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'run-xls'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'run-xls'],
                        'matchCallback' => function ($rule, $action) {
                                $model = AdminUsers::findIdentity(Yii::$app->user->getId());
                                if (!empty($model)) {
                                    return ($model->getRoleId() == 1); // Администратор
                                }
                                return false;
                            }
                    ]
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $file = UploadedFile::getInstanceByName('upload_xls');
        $upload_result = false;
        if (!empty($file)) {
            $path = 'files/uploadxls';
            CDirectory::createDir($path);
            $dir = Yii::$app->basePath . "/../" . $path;
            $fileName = CString::translitTo($file) . "." . $file->getExtension();
            if (is_file(Yii::$app->basePath."/../".$path."/".$fileName)) {
                unlink(Yii::$app->basePath."/../".$path."/".$fileName);
            }
            $upload_result = $file->saveAs($dir . "/" . $fileName);
        }

        return $this->render('index', [
            'file' => $file,
            'fileName' => $fileName,
            'upload_result' => $upload_result
        ]);
    }

    public function actionRunXls()
    {
        $path = 'files/uploadxls';
        $file_name = Yii::$app->request->get('file_name');
        if (isset($_SESSION['start_row'])) {
            $startRow = $_SESSION['start_row'];
        } else {
            $startRow = 10;
        }

        if (empty($file_name))
            throw new NotFoundHttpException('Отсутсвует необходимый параметр.');

        $inputFileType = 'Excel5';
        $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
        $chunkSize = 20;
        $chunkFilter = new chunkReadFilter();
//        echo $startRow;
//        unset($_SESSION['start_row']);
//        die();
//        echo $_SESSION['start_row'];
        while ($startRow <= 65000) {

            $chunkFilter->setRows($startRow, $chunkSize);
            $objReader->setReadFilter($chunkFilter);
            $objReader->setReadDataOnly(true);
            $objPHPExcel = $objReader->load(Yii::$app->basePath . "/../" . "files/uploadxls/" . $file_name);

            $array = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

            if (count($array) == 1) {
                unset($objReader);
                unset($objPHPExcel);

                if (is_file(Yii::$app->basePath."/../".$path."/".$file_name)) {
                    unlink(Yii::$app->basePath."/../".$path."/".$file_name);
                }

                echo "The End";
                unset($_SESSION['start_row']);
                Yii::$app->end();
            } else {
                foreach ($array as $row) {
                    if ($row['B'] != "" && $row['C'] != "" && $row['D'] != "" && $row['E'] != "") {
                        $product = Product::find()->where('code_number = :number', [':number' => $row['B']])->one();
                        if (empty($product)) {
                            $query = new Query();
                            $command = $query->createCommand();
                            $command->insert(Product::tableName(), [
                                'code_number' => $row['B'],
                                'name' => $row['C'],
                                'quantity' => (int) $row['D'],
                                'price' => (double) $row['E'],
                                'visible' => 1
                            ])->execute();
                            unset($query);
                            unset($command);
                        } else {
                            $query = new Query();
                            $command = $query->createCommand();
                            $command->update(Product::tableName(), [
                                    'name'      => $row['C'],
                                    'quantity'  => (int) $row['D'],
                                    'price'     => (double) $row['E'],
                                    'visible' => 1
                                ],
                                'code_number = :number',
                                [':number' => $row['B']])
                                ->execute();
                            unset($query);
                            unset($command);
                        }
                    }
                }
            }

            $startRow += $chunkSize;
            $_SESSION['start_row'] = $startRow;

            unset($objReader);

            unset($objPHPExcel);

        }

        if (is_file(Yii::$app->basePath."/../".$path."/".$file_name)) {
            unlink(Yii::$app->basePath."/../".$path."/".$file_name);
        }
        echo "The End";
        unset($_SESSION['start_row']);
        Yii::$app->end();


//        $sheetData = $excel->getActiveSheet()->toArray(null,true,true,true);
//        var_dump($sheetData);
    }
}