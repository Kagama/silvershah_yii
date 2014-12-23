<?php

namespace backend\modules\catalog\controllers;

use Yii;
use backend\modules\admin\models\AdminUsers;
use common\modules\catalog\models\Manufacture;
use common\modules\catalog\models\search\ManufactureSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use yii\web\UploadedFile;

/**
 * ManufactureController implements the CRUD actions for Manufacture model.
 */
class ManufactureController extends Controller
{

    public function behaviors()
    {
        return [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
////                    'deletePhoto' => ['post'],
//                ],
//            ],

            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'deletePhoto', 'remove-img'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'remove-img'],
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
     * Lists all Manufacture models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ManufactureSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());


        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Manufacture model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
//        echo Yii::$app->basePath."/../common/images";
//        echo Yii::getAlias('cache');
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Manufacture model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Manufacture;

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
     * Updates an existing Manufacture model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

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
     * Deletes an existing Manufacture model.
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
     * Finds the Manufacture model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Manufacture the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Manufacture::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
