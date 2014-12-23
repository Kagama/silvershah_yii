<?php

namespace common\modules\catalog\models;

use common\helpers\CString;
use Yii;

/**
 * This is the model class for table "t_kg_product".
 *
 * @property integer $id
 * @property string $code_number
 * @property string $warranty
 * @property string $model
 * @property integer $manufacture_id
 * @property string $name
 * @property string $alt_name
 * @property string $h1_name
 * @property string $description
 * @property string $overview
 * @property double $old_price
 * @property double $price
 * @property double $discount
 * @property integer $quantity
 * @property integer $product_type_id
 * @property integer $category_id
 * @property integer $visible
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 * @property integer $rate
 * @property integer $rate_count
 * @property integer $pre_order
 * @property integer $yandex_export
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_kg_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code_number', 'quantity', 'name', 'price', 'product_type_id'], 'required'],
            [['manufacture_id', 'quantity', 'product_type_id', 'visible', 'rate', 'rate_count', 'pre_order', 'yandex_export'], 'integer'],
            [['description', 'overview'], 'string'],
            [['code_number'], 'unique'],
            [['old_price', 'price', 'discount'], 'number'],
            [['code_number', 'model', 'name', 'alt_name', 'h1_name', 'seo_title', 'seo_keywords', 'seo_description'], 'string', 'max' => 254],
            [['warranty'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code_number' => 'Актикул',
            'warranty' => 'Гарантия',
            'model' => 'Модель',
            'manufacture_id' => 'Производитель',
            'name' => 'Название',
            'alt_name' => 'Альтернативное название продукта',
            'h1_name' => 'H1 название продукта отображется на странице',
            'description' => 'Описание',
            'overview' => 'Обзор',
            'old_price' => 'Старая цена',
            'price' => 'Цена',
            'discount' => "Скидка",
            'quantity' => 'Количество',
            'product_type_id' => 'Тип продукта',
            'category_id' => 'Категория',
            'visible' => 'Отобразить на сайте',
            'seo_title' => 'Seo Title',
            'seo_keywords' => 'Seo Keywords',
            'seo_description' => 'Seo Description',
            'rate' => 'Rate',
            'rate_count' => 'Rate Count',
            'pre_order' => 'Предзаказ',
            'yandex_export' => 'Выгрузка в Yandex Market',
        ];
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
//            if (count($this->category_id) == 1 && is_array($this->category_id)) {
//                $this->category_id = $this->category_id[0];
//            }
            $this->alt_name = CString::translitTo($this->name);
            return true;
        } else {
            return false;
        }

    }


//    public function beforeSave($insert)
//    {
//        if (parent::beforeSave($insert)) {
//
//
//            return true;
//        } else {
//            return false;
//        }
//    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

//        $PrimaryKey = $this->getPrimaryKey();
//
//        /**
//         * Удаляем все связи с категории с продуктом
//         */
//        ProductCategoryRelation::deleteAll(['product_id' => $PrimaryKey]);
//
//        if (count($this->category_id) > 1) {
//
//            /**
//             * Добавляем все связи с категориями
//             */
//            foreach ($this->category_id as $cat_id) {
//                $cat_prod_rel = new ProductCategoryRelation();
//                $cat_prod_rel->category_id = $cat_id;
//                $cat_prod_rel->product_id = $PrimaryKey;
//                $cat_prod_rel->save();
//            }
//            static::updateAll(['category_id' => null], ['id' => $PrimaryKey]);
//        } else {
//
//            static::updateAll(['category_id' => $this->category_id[0]], ['id' => $PrimaryKey]);
//        }

    }

    // Получить фото(графии)
    public function getPhotos()
    {
        return $this->hasMany(ProductPhoto::className(), ['product_id' => 'id']);
    }

    // Сопуствующие товары
    public function getRelProducts()
    {
        return $this->hasMany(ProductsRelatedProduct::className(), ['product_id' => 'id']);
    }

    public function getRelProductModels()
    {
        return $this->hasMany(Product::className(), ['id' => 'related_product_id'])
            ->via('relProducts');
    }

    // Cross Sell товары
    public function getUpSell()
    {
        return $this->hasMany(ProductUpSell::className(), ['product_id' => 'id']);
    }

    // Up Sell товары
    public function getCrossSell()
    {
        return $this->hasMany(ProductCrossSell::className(), ['product_id' => 'id']);
    }

    public function getCrossSellProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'related_product_id'])
            ->via('crossSell');
    }

    // Связанные свойства продукта
    public function getPropertyValueRelation()
    {
        return $this->hasMany(ProductPropertyValueRelation::className(), ['product_id' => 'id']);
    }


    public function beforeDelete()
    {
        if (parent::beforeDelete()) {

            // Удаляем фотографии связанные с продуктом
            $photos = $this->photos;
            if (!empty($photos)) {
                foreach ($photos as $photo) {
                    $photo->delete();
                }
            }

            return true;
        } else {
            return false;
        }
    }

    public function getCategory()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'category_id']);
    }

    public function getComments()
    {
        return $this->hasMany(ProductComment::className(), ['product_id' => 'id'])->onCondition(['approve' => 1]);
    }

    public function getRateValue()
    {
        $comments = $this->comments;
        $rate = 0;
        $rate_count = count($comments);

        foreach ($comments as $comm) {
            $rate += $comm->rate;
        }
        return $rate_count == 0 ? 0 : ceil(($rate / $rate_count));
    }

    public function priceWithDiscount($discount = null)
    {
        $discount = ($discount == null ? (empty($this->discount) ? null : $this->discount) : $discount);
        if ($discount != null) {
            return ceil($this->price - (($this->price * $discount) / 100));
        }
        return null;
    }
}
