<?php

namespace backend\modules\order\controllers;

use common\modules\order\models\OrderDeliveryInfo;
use Yii;
use common\modules\order\models\Order;
use common\modules\order\models\search\OrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\modules\admin\models\AdminUsers;

/**
 * DefaultController implements the CRUD actions for Order model.
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['post'],
//                ],
//
//            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'order-xls'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'order-xls'],
//                        'roles' => ['@']
                        'matchCallback' => function ($rule, $action) {
//                                if ($action != 'logout') {
                                $model = AdminUsers::findIdentity(Yii::$app->user->getId());
                                if (!empty($model)) {
                                    return $model->getRoleId() == 1; // Администратор
                                }
                                return false;
//                                }
//                                return false;
                            }
                    ]
                ]
            ]
        ];
    }

    public function actionOrderXls($id)
    {
        $order = $this->findModel((int) $id);

        $writeFileType = 'Excel5';
        $phpExcel = new \PHPExcel();
        $phpExcel->getProperties()->setCreator("Kvadro EMarket By Kagama Commerce")
                                    ->setLastModifiedBy(AdminUsers::findOne(Yii::$app->user->getId())->username)
                                    ->setTitle("Заказа № ".$order->id." от ".date('d/m/Y', $order->date))
                                    ->setSubject("Заказа № ".$order->id." от ".date('d/m/Y', $order->date));


        $cartItems = $order->cart->cartItems;


        $phpExcel->getActiveSheet()->getStyle('A1')->applyFromArray(
            array(
                'fill' => array(
                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'D2D2D2')
                )
            )
        );
        $phpExcel->getActiveSheet()->getStyle('B1')->applyFromArray(
            array(
                'fill' => array(
                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'D2D2D2')
                )
            )
        );
        $phpExcel->getActiveSheet()->getStyle('C1')->applyFromArray(
            array(
                'fill' => array(
                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'D2D2D2')
                )
            )
        );
        for ($col = 'A'; $col != 'D'; $col++) {
            $phpExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);

        }
        $phpExcel->getActiveSheet()->getStyle("A1:C1")->getFont()->setSize(14);

        $phpExcel->getActiveSheet()->setCellValue('A' . 1, "Артикул");
        $phpExcel->getActiveSheet()->setCellValue('B' . 1, 'Название продкута');
        $phpExcel->getActiveSheet()->setCellValue('C' . 1, 'Количетсво');
        $i = 2;
        foreach ($cartItems as $item) {
            $phpExcel->getActiveSheet()->setCellValue('A' . $i, $item->product->code_number);
            $phpExcel->getActiveSheet()->setCellValue('B' . $i, $item->product->name);
            $phpExcel->getActiveSheet()->setCellValue('C' . $i, $item->quantity);
//            $phpExcel->getActiveSheet()->setCellValue('C' . $i, $item->quantity);
            $i++;
        }
        $phpExcel->setActiveSheetIndex(0);

        $objExcel = \PHPExcel_IOFactory::createWriter($phpExcel, $writeFileType);
//        $objExcel->save(Yii::$app->basePath . "/../" . "files/orders/order_".$order->id.".xls");
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');

        // It will be called file.xls
        header('Content-Disposition: attachment; filename="order_'.$order->id.'.xls"');

        // Write file to the browser
        $objExcel->save('php://output');
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $deliveryInfo = OrderDeliveryInfo::findByOrderId($model->id);
        $deliveryInfo->order_id = $model->getPrimaryKey();

        if ( ($model->load(Yii::$app->request->post()) && $model->save()) &&
             ($deliveryInfo->load(Yii::$app->request->post()) && $deliveryInfo->save()) ) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'delivery' => $deliveryInfo
            ]);
        }
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
