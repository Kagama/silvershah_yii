<?php

namespace backend\modules\catalog\controllers;

use Yii;
use common\modules\catalog\models\ProductSlider;
use common\modules\catalog\models\search\ProductSliderSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use backend\modules\admin\models\AdminUsers;
use yii\web\UploadedFile;

/**
 * SliderController implements the CRUD actions for ProductSlider model.
 */
class SliderController extends Controller
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
                'only' => ['index', 'view', 'create', 'update', 'delete', 'delete-photo'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'delete-photo'],
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

    /**
     * Lists all ProductSlider models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSliderSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionDeletePhoto($id)
    {
        $model = $this->findModel($id);
        $model->deletePhoto();
        $model->img_name = "";
        $model->src = "";
        if ($model->save()) {
            $this->redirect(['/catalog/slider/update', 'id' => $model->id]);

        }
    }

    /**
     * Displays a single ProductSlider model.
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
     * Creates a new ProductSlider model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductSlider;

        if ($model->load(Yii::$app->request->post())) {
            $model->img_name = UploadedFile::getInstance($model, 'img_name');

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProductSlider model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $img_name = UploadedFile::getInstance($model, 'img_name');
            if (!empty($img_name)) {
                $model->img_name = $img_name;
            }

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProductSlider model.
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
     * Finds the ProductSlider model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductSlider the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductSlider::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
