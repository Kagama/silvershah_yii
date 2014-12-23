<?php

namespace backend\modules\catalog\controllers;

use Yii;
use backend\modules\admin\models\AdminUsers;
use common\modules\catalog\models\ProductCategory;
use common\modules\catalog\models\search\ProductCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;

use yii\web\UploadedFile;

/**
 * CategoryController implements the CRUD actions for ProductCategory model.
 */
class CategoryController extends Controller
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
                'only' => ['index', 'view', 'create', 'update', 'delete', 'remove-img', 'update-position'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'remove-img', 'update-position'],
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

    public function actionUpdatePosition($id) {
        if (Yii::$app->request->isAjax) {
            $model = ProductCategory::findOne((int) $id);
            $old_position = $model->position;
            $new_position = Yii::$app->request->post('new_pos');
            if ($old_position != $new_position) {
                $model->position = $new_position;
                if ($model->save()) {
                    echo json_encode(array('error' => false));
                } else {
                    echo json_encode(array('error' => true));
                }
            }
        }
    }

    public function actionRemoveImg($id)
    {
        $model = $this->findModel((int)$id);
        $model->deletePhoto();
        $model->img = "";
        $model->src = "";
        if ($model->save(false)) {
            $this->redirect(['update', 'id' => $model->id]);
        }
    }

    /**
     * Lists all ProductCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductCategorySearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'models' => ProductCategory::find()->orderBy(['position' => 'ASC'])->all()
        ]);
    }

    /**
     * Displays a single ProductCategory model.
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
     * Creates a new ProductCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductCategory;

        if ($model->load(Yii::$app->request->post())) {

            $model->img = UploadedFile::getInstance($model, 'img');

            if ($model->save()) {
                $model->uploadPhoto();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);

    }

    /**
     * Updates an existing ProductCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
//        print_r($_POST);
//        print_r($_FILES);
        if ($model->load(Yii::$app->request->post())) {

            $model->img = UploadedFile::getInstance($model, 'img');

            if ($model->save()) {
                $model->uploadPhoto();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);

    }

    /**
     * Deletes an existing ProductCategory model.
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
     * Finds the ProductCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
