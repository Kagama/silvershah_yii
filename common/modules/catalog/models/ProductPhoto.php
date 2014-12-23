<?php

namespace common\modules\catalog\models;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use common\helpers\CDirectory;
use common\helpers\CString;

/**
 * This is the model class for table "t_kg_product_photo".
 *
 * @property integer $id
 * @property string $name
 * @property string $src
 * @property integer $product_id
 * @property integer $is_main
 * @property integer $is_popular
 */
class ProductPhoto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_kg_product_photo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'safe'],
            //[['name'], 'required'], // , 'src', 'product_id'
            [['product_id', 'is_main', 'is_popular'], 'integer'],
//            [['name'], 'string', 'max' => 254],
            [['src'], 'string', 'max' => 2024],
            [['name'], 'file', 'extensions' => 'jpg, gif, jpeg, png', 'skipOnEmpty' => true],


        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Фотография',
            'src' => 'Путь к фото',
            'product_id' => 'ID Продукта',
            'is_main' => 'Главная фотография',
            'is_popular' => 'Популярная фотография',
        ];
    }

    public function behaviors()
    {
        return [
            'slug' => [
                'class' => 'common\behaviors\CachedImageResolution',
                'attr_src' => 'src',
                'attr_img_name' => 'name',
            ]
        ];
    }

    public function uploadAndSavePhoto(Product $model) {
        if ($this->name instanceof UploadedFile && $this->name->size > 0) {

            $path = 'images/modules/catalog/product/'.$model->product_type_id."/".$model->getPrimaryKey();
            CDirectory::createDir($path);
            $dir = Yii::$app->basePath."/../".$path; //Yii::getAlias('@common/images/');
            $imageName = md5(CString::translitTo($this->name) . microtime()) . "." . $this->name->getExtension();
            $this->name->saveAs($dir."/".$imageName);
            $this->name = $imageName;
            $this->src = $path;
            $this->product_id = $model->getPrimaryKey();
            $this->save();
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
    public function deletePhoto() {
        if (is_file(Yii::$app->basePath."/../".$this->src."/".$this->name)) {
            unlink(Yii::$app->basePath."/../".$this->src . "/" . $this->name);
            FileHelper::removeDirectory(Yii::$app->basePath."/../cache/".$this->src);
        }
    }
}
