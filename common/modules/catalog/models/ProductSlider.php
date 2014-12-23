<?php

namespace common\modules\catalog\models;

use common\helpers\CDirectory;
use common\helpers\CString;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "t_kg_product_slider".
 *
 * @property integer $id
 * @property string $name
 * @property integer $active
 * @property string $img_name
 * @property string $src
 * @property string href
 */
class ProductSlider extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_kg_product_slider';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['active'], 'integer'],
            [['name'], 'string', 'max' => 512],
            [['img_name'], 'file', 'types' => ['jpg', 'jpeg', 'png']],
            [['src'], 'string', 'max' => 2024],
            [['href'], 'url']
        ];
    }

    public function behaviors()
    {
        return [
            'slug' => [
                'class' => 'common\behaviors\CachedImageResolution',
                'attr_src' => 'src',
                'attr_img_name' => 'img_name',
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название слайда',
            'active' => 'Отобразить',
            'img_name' => 'Слайд',
            'src' => 'Путь к слайду',
            'href' => 'Ссылка на страницу'
        ];
    }

//    public function beforeValidate()
//    {
//        if () {
//
//        }
//        return false;
//    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->img_name instanceof UploadedFile && $this->img_name->size > 0) {

                $path = 'images/modules/catalog/slider';
                CDirectory::createDir($path);
                $dir = Yii::$app->basePath . "/../" . $path; //Yii::getAlias('@common/images/');
                $imageName = md5(CString::translitTo($this->img_name) . microtime()) . "." . $this->img_name->getExtension();
                $this->img_name->saveAs($dir . "/" . $imageName);
                $this->img_name = $imageName;
                $this->src = $path;
            }
            return true;
        } else {
            return false;
        }

    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $this->deletePhoto();
            return true;
        } else {
            return false;
        }
    }

    public function deletePhoto()
    {
        if (is_file(Yii::$app->basePath . "/../" . $this->src . "/" . $this->img_name)) {
            unlink(Yii::$app->basePath . "/../" . $this->src . "/" . $this->img_name);
        }
    }
}
