<?php

namespace backend\modules\catalog\controllers;

use common\modules\catalog\models\ProductPhoto;
use Yii;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\modules\admin\models\AdminUsers;
use yii\filters\AccessControl;

/**
 * DefaultController implements the CRUD actions for Product model.
 */
class PhotoController extends Controller
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
                'only' => ['delete', 'ajax-rotate', 'ajax-change-main-status'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['delete', 'ajax-rotate', 'ajax-change-main-status'],
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

    public function actionAjaxChangeMainStatus($id) {
        if (Yii::$app->request->isAjax) {
            $model = $this->findModel($id);
            if (!empty($model)) {
                ProductPhoto::updateAll(['is_main' => 0]);
                $model->is_main = 1;
                if ($model->save()) {
                    return json_encode(['error' => false]);
                } else {
                    return json_encode(['error' => true, 'message' => $model->getErrors()]);
                }
            }
            return false;
        }
    }

    public function actionAjaxRotate($id) {
        if (Yii::$app->request->isAjax) {
            $photo = $this->findModel($id);

            if (!empty($photo)) {
                //FileHelper::removeDirectory(Yii::$app->basePath."/../".$this->src);

                FileHelper::removeDirectory(Yii::$app->basePath."/../cache/".$photo->src);

                $img = Yii::$app->image->load(Yii::$app->basePath."/../".$photo->src . "/" . $photo->name);

                if ($img->rotate(90)->save(Yii::$app->basePath."/../".$photo->src . "/" . $photo->name)) {
                    $photo->doCache('200x200');
                    return json_encode(array('error' => false));

                } else {
                    return json_encode(array('error' => true, 'message' => 'Фото неудалено'));

                }
            }
            return json_encode(array('error' => true, 'message' => 'Фото не найдено'));

        }

        /**/
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->request->isAjax) {
            $model = $this->findModel($id);
                if (!empty($model)) {
                    if ($model->delete()) {
                        return json_encode(array('error' => false));
                    } else {
                        return json_encode(array('error' => true, 'message' => $model->getErrors()));
                    }
                }
        }

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
        if (($model = ProductPhoto::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
