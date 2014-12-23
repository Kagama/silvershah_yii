<?php

namespace common\modules\catalog\models;

use common\helpers\CString;
use Yii;
use common\helpers\CDirectory;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * This is the model class for table "t_kg_product_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $h1
 * @property string $alt_name
 * @property string $url
 * @property integer $parent_id
 * @property integer $level
 * @property integer $position
 * @property string $img
 * @property string $src
 * @property string $text_before
 * @property string $text_after
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 */
class ProductCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_kg_product_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'h1'], 'required'],
            [['parent_id', 'level', 'position'], 'integer'],
            [['text_before', 'text_after', 'seo_description'], 'string'],
            [['name', 'alt_name', 'seo_title', 'h1'], 'string', 'max' => 254],
            [['src', 'seo_keywords', 'url'], 'string', 'max' => 512],
            [['img'], 'image', 'extensions' => 'jpg, gif, jpeg, png', 'skipOnEmpty' => true, 'isEmpty' => function () {
                return null;
            }],
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
            'h1' => 'H1 Отображается на сайте',
            'alt_name' => 'Alt Название',
            'url' => 'Ссылка',
            'parent_id' => 'Родитель ID',
            'level' => 'Уровень вложенности',
            'position' => 'Позиция',
            'img' => 'Картинка',
            'src' => 'Путь к файлу',
            'text_before' => 'Текст до вывода продуктов',
            'text_after' => 'Текст после вывода продуктов',
            'seo_title' => 'Seo Заголовок',
            'seo_keywords' => 'Seo Ключевые слова',
            'seo_description' => 'Seo Описание',
        ];
    }

    /*
     * Получить связные продукты
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {

            // Сохраняем транслит названия категории
            if ($this->alt_name == "") {
                $this->alt_name = CString::translitTo($this->name);
            }


            // Увеличиваем Level если parent_id выбран
            if (!empty($this->parent_id)) {
                $parent = ProductCategory::findOne(['id' => $this->parent_id]);
                $this->level = $parent->level + 1;

                // Создаем раут
                $this->url = $parent->url . "/" . $this->alt_name;

            } else {
                // Создаем раут
                $this->url = $this->alt_name;
            }


            // Если позиция не заполнена то номер отображения позиции 999
            if (empty($this->position)) {
                $this->position = 999;
            }

            return true;
        }
        return false;
    }

    public function uploadPhoto()
    {

        if ($this->img instanceof UploadedFile && $this->img->size > 0) {
            $path = 'images/modules/catalog/category/' . $this->getPrimaryKey();
            CDirectory::createDir($path);
            $dir = Yii::$app->basePath . "/../" . $path; //Yii::getAlias('@common/images/');
            $imageName = md5(CString::translitTo($this->img) . microtime()) . "." . $this->img->getExtension();
            $this->img->saveAs($dir . "/" . $imageName);
            $this->img = $imageName;
            $this->src = $path;
            $this->save();
        }
    }

    public function deletePhoto()
    {
        if (is_file(Yii::$app->basePath . "/../" . $this->src . "/" . $this->img)) {
            FileHelper::removeDirectory(Yii::$app->basePath . "/../" . $this->src);
            FileHelper::removeDirectory(Yii::$app->basePath . "/../cache/" . $this->src);
        }
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {

            // Удаляем дочерние категории если они имеются
            $this->deleteChildItems($this->children);

            $this->deletePhoto();
            return true;
        } else {
            return false;
        }
    }

    // TODO Создать класс меню и перенести функционал создяния меню в него.
    public function getArrayToMbMenu()
    {
        $objArray = $this->find()->orderBy(['position' => 'ASC'])->all();

        $returnArray = array();
        $returnArray = array('items' => $this->getTree($objArray, NULL));
        return $returnArray;
    }

    /**
     * Формируем массив ввиде дерева так как это необходимо MbMenu.
     * Для быстроты выборки unset($arr[$index]); удаляет элемент массива объектов Menu который уже был добавлен в массив $returnArray
     *
     * Возвращаемый массив предоставляется в следующем виде
     * array(
     *      'items' => array(
     *              array('label' => 'Home', 'url' => array('/site/index')),
     *              array('label' => 'Contact', 'url' => array('/site/contact'),
     *                      'items' => array(
     *                              array('label' => 'sub 1 contact'),
     *                              array('label' => 'sub 2 contact'),
     *                              ),
     *                      ),
     *              ),
     * )
     *
     * @param <array> $arr
     * @param <integer> $ownerId
     * @return <array>
     */
    private function getTree($arr, $parent_id = NULL)
    {
        foreach ($arr as $index => $obj) {
            if ($obj->parent_id == $parent_id) {
                $tempObj = $obj;
                unset($arr[$index]);
                $returnArray[] = ['label' => $tempObj->name, 'url' => Url::to(['/catalog/category' . $tempObj->id . "_" . CString::translitTo($tempObj->alt_name)]), 'items' => $this->getTree($arr, $tempObj->id)];
            }
        }
        return $returnArray;
    }

//    public function getParentName() {
//        $parent = $this->hasOne(ProductCategory::className(),  ['id' => 'parent_id']);
//        return $parent;
//    }

    //TODO: Перенести функционал вывода UL в другую сущность
    public function getUl($model = false, $multiChecking = false)
    {
        $objArray = $this->find()->orderBy(['position' => 'ASC'])->all();
        $checked_cat = [];

        if ($multiChecking == true) {

//            if ($model->category_id != null) {
//                $checked_cat = [$model->category_id];
//            } else {
            /**
             * получаем список всех категорий которые связанные с продуктом
             */
            $categories = ProductCategoryRelation::find()->where(['product_id' => $model->getPrimaryKey()])->all();;
            foreach ($categories as $cat) {
                $checked_cat[] = $cat->category_id;
            }
//            }

        }
        $html = "<ul class='category-checkbox'>\n" . $this->renderUl($objArray, null, $checked_cat) . "</ul>\n";

        // Если $multiChecking == false
        if ($multiChecking == false) {
            $html .= "<script type='text/javascript'>
                $('.category-checkbox label').css('cursor', 'pointer');
                $('.category-checkbox input:checkbox').on('click', function() {
//                    alert($(this).checked);
                    // Uncheck all
                    $('.category-checkbox input:checkbox').each(function(i){
                        $(this).prop('checked', false);
                    });
                    $(this).prop('checked', true);
                })
            </script>";
        }

        return $html;

    }

    private function renderUl($arr, $parent_id = NULL, $cheched = [])
    {
        $htmlUL = "";
        foreach ($arr as $index => $obj) {
            if ($obj->parent_id == $parent_id) {
                $tempObj = $obj;
                unset($arr[$index]);
                $child = $this->renderUl($arr, $obj->id, $cheched);

                if (!empty($child)) {
                    $htmlUL .= "<li>\n<strong>" . $tempObj->name . "</strong>\n";
                    $htmlUL .= "<ul>\n" . $child . "\n</ul>\n";

                } else {
                    $htmlUL .= "<li>\n<label>" . Html::checkbox('ProductCategory[id][]', (in_array($tempObj->id, $cheched)), ['value' => $tempObj->id]) . " " . $tempObj->name . "</label>\n";
                    $htmlUL .= "</li>\n";
                }

            }
        }
//        $htmlUL .= ;
        return $htmlUL;
    }


    public function getChildren()
    {
        return self::hasMany(ProductCategory::className(), ['parent_id' => 'id'])->orderBy('position, level ASC ');
    }

    public function getParent() {
        return self::hasOne(ProductCategory::className(), ['id' => 'parent_id']);
    }


    private function deleteChildItems($items)
    {
        if (empty($items)) return null;

        foreach ($items as $i => $ch) {
            if (!empty($ch->children))
                $this->deleteChildItems($ch->children);

            $ch->delete();

        }

        return true;

    }

    /**
     *
     * Связываем товар с категориями
     *
     * @param ActiveRecord $_model
     */
    public static function addRel(ActiveRecord $_model)
    {
        $PrimaryKey = $_model->getPrimaryKey();

        /**
         * Удаляем все связи с категории с продуктом
         */
        ProductCategoryRelation::deleteAll(['product_id' => $PrimaryKey]);

        /**
         * Добавляем все связи с категориями
         */
        foreach (Yii::$app->request->post('ProductCategory')['id'] as $category_id) {
            $cat_prod_rel = new ProductCategoryRelation();
            $cat_prod_rel->category_id = $category_id;
            $cat_prod_rel->product_id = $PrimaryKey;
            $cat_prod_rel->save();
        }
    }

    public function getCssClassName()
    {
        $class = '';
        if ($this->name == "Подарки из серебра, сувениры") {
            $class = 'gift';
        }
        if ($this->name == "Кубачинское серебро") {
            $class = 'kub';
        }
        if ($this->name == "Серебряная посуда") {
            $class = 'pos';
        }
        if ($this->name == "Сервизы и столовые наборы") {
            $class = 'serv';
        }
        if ($this->name == "Оружие из серебра") {
            $class = 'or';
        }
        if ($this->name == "Эксклюзивная серебряная работа") {
            $class = 'ex';
        }
        if ($this->name == "Антиквариат") {
            $class = 'ant';
        }

        return $class;
    }

    public function prepareUrl()
    {
        return str_replace("_", "-", $this->url);
    }

}

