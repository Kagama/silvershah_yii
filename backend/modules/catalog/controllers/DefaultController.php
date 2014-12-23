<?php

namespace backend\modules\catalog\controllers;

use common\helpers\CDirectory;
use common\modules\catalog\models\ProductCategory;
use common\modules\catalog\models\ProductCrossSell;
use common\modules\catalog\models\ProductPhoto;
use common\modules\catalog\models\ProductPropertyValue;
use common\modules\catalog\models\ProductPropertyValueRelation;
use common\modules\catalog\models\ProductsRelatedProduct;
use common\modules\catalog\models\ProductUpSell;
use Yii;
use common\modules\catalog\models\Product;
use common\modules\catalog\models\search\ProductSearch;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use backend\modules\admin\models\AdminUsers;
use yii\filters\AccessControl;

/**
 * DefaultController implements the CRUD actions for Product model.
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'get-product-by-code-number'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'get-product-by-code-number'],
//                        'roles' => ['@']
                        'matchCallback' => function ($rule, $action) {
//                                if ($action != 'logout') {
                            $model = AdminUsers::findIdentity(Yii::$app->user->getId());
                            if (!empty($model)) {
                                return ($model->getRoleId() == 1); // Администратор
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

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        /**
         * Добавление свойств
         */
//        $query = new Query();
//
//        $query->select('*')
//            ->from('catalog');
//
//        $catalog = $query->all();
//
//        foreach($catalog as $old_prod) {
//            // серебро
//            $property_value = ProductPropertyValue::find()->where(['property_id' => 117, 'value' => $old_prod['silver']])->one();
//            if ($property_value == null) {
//                $value = new ProductPropertyValue();
//                $value->property_id = 117;
//                $value->value = $old_prod['silver'];
//                $value->save();
//                unset($value);
//            } else {
//                $rel = new ProductPropertyValueRelation();
//                $rel->product_id = $old_prod['id'];
//                $rel->property_value_id = $property_value->getPrimaryKey();
//                $rel->save();
//                unset($rel);
//            }
//
//            unset($property_value);
//        }

        /**
         * добавление фото
         */
//        $query = new Query();
//        $query->select('*')->from('photo');
//        $photos = $query->all();
//
//        foreach ($photos as $photo) {
//
//            $prod = Product::findOne($photo['ownerId']);
//            if ($prod != null) {
//                $path = 'images/modules/catalog/product/'.$prod->product_type_id."/".$prod->getPrimaryKey();
//                if (CDirectory::createDir($path)) {
//                    $dir = Yii::$app->basePath."/../".$path; //Yii::getAlias('@common/images/');
//
//                    if (file_exists(Yii::$app->basePath."/../"."images/old_files/".$photo['src'])) {
//                        $_p = new ProductPhoto();
//                        $_p->name = $photo['src'];
//                        $_p->src = $path;
//                        $_p->product_id = $photo['ownerId'];
//                        $_p->save();
//
//                        //rename(Yii::$app->basePath."/../".'images/old_files/'.$photo['src'], Yii::$app->basePath."/../".$path."/".$photo['src']);
//                        copy(Yii::$app->basePath."/../"."images/old_files/".$photo['src'] , Yii::$app->basePath."/../".$path."/".$photo['src']);
//                    }
//
//                }
//
//            } else {
//                echo $photo['ownerId']." | ";
//            }
//
//        }



        $searchModel = new ProductSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Product model.
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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Product;
        $photos = new ProductPhoto;
        $temp_photos = null;
        $validate = true;

//        print_r($_POST);
//        return ;
        if (isset($_POST['Product'])) {
            // проверям валидность загружаемых файлов
            $files = UploadedFile::getInstances($photos, 'name');
            foreach ($files as $index => $file) {
                $temp_photos[$index] = new ProductPhoto;
                $temp_photos[$index]->name = $file;
                if (!$temp_photos[$index]->validate()) {
                    $validate = false;
                    $photos = $temp_photos[$index];
                }
            }

            // Данные о продукте
            $model->load(Yii::$app->request->post());
            $validate = $validate && $model->validate();

            // Сохраняем модель Product
            if ($validate && $model->save()) {

                $product_id = $model->getPrimaryKey();

                // Загружаем файлы и сохраняем ProductPhoto
                if ($temp_photos != null)
                    foreach ($temp_photos as $index => $photo) {
                        $photo->uploadAndSavePhoto($model);
                    }

                // Сохраняем свойства продукта
                $propValueRelation = new ProductPropertyValueRelation();
                $propValueRelation->createRelation($product_id);
                //

                // Сопутсвующие товары
                ProductsRelatedProduct::addRel($model->id);

                // Up Sell
                ProductUpSell::addRel($model->id);

                // Cross Sell
                ProductCrossSell::addRel($model->id);
                if (Yii::$app->request->post('submit') == 'save-and-continue') {
                    return $this->redirect(['create']);
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }

        }


        return $this->render('create', [
            'model' => $model,
            'photos' => $photos
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $photos = new ProductPhoto;
        $temp_photos = null;
        $validate = true;

        if (isset($_POST['Product'])) {
            $files = UploadedFile::getInstances($photos, 'name');
            if (!empty($files)) {
                foreach ($files as $index => $file) {
                    $temp_photos[$index] = new ProductPhoto;
                    $temp_photos[$index]->name = $file;
                    if (!$temp_photos[$index]->validate()) {
                        $validate = false;
                        $photos = $temp_photos[$index];
                    }
                }
            }

            // Данные о продукте
            $model->load(Yii::$app->request->post());
            $validate = $validate && $model->validate();

            // Сохраняем модель Product
            if ($validate && $model->save()) {

                $product_id = $model->getPrimaryKey();

                // Загружаем файлы и сохраняем ProductPhoto
                if ($temp_photos != null)
                    foreach ($temp_photos as $index => $photo) {
                        $photo->uploadAndSavePhoto($model);
                    }

                // Сохраняем свойства продукта
                $propValueRelation = new ProductPropertyValueRelation();
                $propValueRelation->createRelation($product_id);
                //

                //Категория продкута
                ProductCategory::addRel($model);

                // Сопутсвующие товары
                ProductsRelatedProduct::addRel($model->id);

                // Up Sell
                ProductUpSell::addRel($model->id);

                // Cross Sell
                ProductCrossSell::addRel($model->id);

                return $this->redirect(['view', 'id' => $model->id]);
            }

        }

        return $this->render('update', [
            'model' => $model,
            'photos' => $photos
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

//    public function actionGetProductByCodeNumber () {
//        if (!empty($_GET['q'])) {
//            $name = $_GET['q'];
//            $name = addcslashes($name, '%_');
//            $limit = min($_GET['limit'], 50);
//
//            $userArray = Product::find()->
//                select('id, code_number, name ')->
//                where('code_number LIKE :number', [':number' => "%$name%"])->
//                orderBy('code_number ASC')->
//                limit($limit)->all();
//            $returnVal = '';
//            foreach ($userArray as $userAccount) {
//                $returnVal .= $userAccount->code_number.'|'.$userAccount->name.'|'.((empty($userAccount->photos[0]) ? "" : $userAccount->photos[0]->goCache('100x100') )).'|'.$userAccount->id."\n";
//            }
//            echo  $returnVal;
//        } else {
//            return false;
//        }
//    }
}
