<?php
namespace backend\modules\catalog\widgets;

use common\modules\catalog\models\ProductPropertyValueRelation;
use common\modules\catalog\models\ProductTypePropertyRelation;
use yii\base\Widget;

/**
 * Created by PhpStorm.
 * User: developer
 * Date: 25.05.14
 * Time: 18:45
 */
class PropertyRenderWidget extends Widget
{

    /**
     * Тип продукта
     *
     * @var integer
     *
     */
    public $type_id;

    /**
     * Продукт
     *
     * @var integer
     */
    public $product_id;

    /**
     * @var array ProductTypePropertyRelation
     */
    private $productTypePropertyRelation = null;

    /**
     * @var array ProductPropertyValueRelation
     */
    private $prodPropertyValues = null;

    public function run()
    {
        if (!empty($this->type_id)) {
            $this->productTypePropertyRelation = ProductTypePropertyRelation::find()->
                where(['type_id' => (int)$this->type_id])->
                orderBy('property_group_id, position_number ASC ')->all();
        }
//            throw new InvalidCallException("Свойство \"" . get_called_class() . '::$type_id" не должно быть пустым');

        return $this->renderContent();

    }

    private function renderContent() {
        return $this->render('propertyRenderWidget',[
            'productTypePropertyRelation' => $this->productTypePropertyRelation,
            'product_id' => $this->product_id
        ]);
    }
}