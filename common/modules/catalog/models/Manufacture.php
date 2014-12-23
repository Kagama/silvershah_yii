<?php

namespace common\modules\catalog\models;

use common\helpers\CDirectory;
use common\helpers\CString;
use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "t_kg_manufacture".
 *
 * @property integer $id
 * @property string $name
 * @property string $alt_name
 * @property string $text
 * @property string $img
 * @property string $src
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 */
class Manufacture extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_kg_manufacture';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'text'], 'required'],
            [['text', 'seo_description'], 'string'],
            [['name', 'alt_name'], 'string', 'max' => 254],
            [['src', 'seo_title', 'seo_keywords'], 'string', 'max' => 512],
            [['img'], 'image', 'extensions' => 'jpg, gif, jpeg, png'],
            [['img'], 'safe'],
        ];
    }

    public function behaviors()
    {
        return [
            'slug' => [
                'class' => 'common\behaviors\CachedImageResolution',
                'attr_src' => 'src',
                'attr_img_name' => 'img',
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
            'name' => 'Название',
            'alt_name' => 'Alt Название',
            'text' => 'Описание',
            'img' => 'Название фото',
            'src' => 'Путь к фото',
            'seo_title' => 'SEO Заголовок',
            'seo_keywords' => 'SEO Ключевые слова',
            'seo_description' => 'SEO Описание',
        ];
    }

    public function beforeValidate() {
        if (parent::beforeValidate()) {
            $this->alt_name = CString::translitTo($this->name);
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes) {



        parent::afterSave($insert, $changedAttributes);
    }

    public function uploadPhoto () {
        if ($this->img instanceof UploadedFile && $this->img->size > 0) {
            $path = 'images/modules/catalog/manufacture/'.$this->getPrimaryKey();
            CDirectory::createDir($path);
            $dir = Yii::$app->basePath."/../".$path; //Yii::getAlias('@common/images/');
            $imageName = md5(CString::translitTo($this->img) . microtime()) . "." . $this->img->getExtension();
            $this->img->saveAs($dir."/".$imageName);
            $this->img = $imageName;
            $this->src = $path;
            $this->save();
        }
    }

    public function deletePhoto() {
        if (is_file(Yii::$app->basePath."/../".$this->src."/".$this->img)) {
            FileHelper::removeDirectory(Yii::$app->basePath."/../".$this->src);
            FileHelper::removeDirectory(Yii::$app->basePath."/../cache/".$this->src);
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
}
