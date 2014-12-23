<?php

namespace backend\modules\catalog\controllers;

use backend\modules\catalog\widgets\PropertyRenderWidget;
use Yii;
use backend\modules\admin\models\AdminUsers;
use common\modules\catalog\models\ProductProperty;
use common\modules\catalog\models\search\ProductPropertySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;


/**
 * ProductPropertyController implements the CRUD actions for ProductProperty model.
 */
class ProductPropertyController extends Controller
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
                'only' => ['index', 'view', 'create', 'update', 'delete', 'get-properties-by-type'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'get-properties-by-type'],
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


    public function actionGetPropertiesByType () {
        if (Yii::$app->request->isAjax) {

            $type_id = Yii::$app->request->post('type_id');
            $product_id = Yii::$app->request->post('product_id');

            $widget = PropertyRenderWidget::widget([
                'type_id' => (int) $type_id,
                'product_id' => (int) $product_id
            ]);

            echo json_encode(['error' => false, 'html' => $widget]);
        }
    }

    /**
     * Lists all ProductProperty models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductPropertySearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single ProductProperty model.
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
     * Creates a new ProductProperty model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductProperty;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (Yii::$app->request->post('save_and_add_new') == "save") {
                return $this->redirect(['create', 'group_id' => $model->group_id]);
            } else {
                return $this->redirect(['view', 'id' => $model->id]);
            }

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProductProperty model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProductProperty model.
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
     * Finds the ProductProperty model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductProperty the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductProperty::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
