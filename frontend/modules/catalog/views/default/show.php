<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 23.07.14
 * Time: 20:09
 */
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\web\View;


Yii::$app->view->registerJs("
//    $('.fancybox-thumb').fancybox({
//        prevEffect	: 'none',
//        nextEffect	: 'none',
//        helpers	: {
//            title	: {
//                type: 'outside'
//            },
//            thumbs	: {
//                width	: 50,
//                height	: 50
//            }
//        }
//    });
//
//    $('.add-comment-btn').on('click', function(){
//    var _url = $(this).attr('href');
//    $.ajax({
//        type:'get',
//        dataType:'json',
//        url:_url,
//        success : function(json) {
//            if (json.error) {
//                alert(json.message);
//            } else {
//                $('.comment-form-block').empty();
//                $('.comment-form-block').html(json.content);
//            }
//        }
//    });
//
//    return false;
//   });

", \yii\web\View::POS_END, 'product-show-photo');


$this->params['breadcrumbs'] = [
//    ['label' => $model->category->name, 'url' => ['/catalog/' . $model->category->alt_name]],
    ['label' => $model->name, 'url' => null],
];


$this->title = $model->name." - ".Yii::$app->params['seo_title'];
Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => $model->seo_keywords]);
Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => $model->seo_description]);

?>
<section class="itemdata">
    <div class="container">

        <h1><?=$model->h1_name;?> <?=$model->code_number?></h1>

        <?php
        if (!empty($model->photos)) {
        ?>
        <div class="photos">
            <div class="big-img">
                <?=Html::img("/".$model->photos[0]->doCache('481x481', 'auto', '481x481'), ['alt' => $model->h1_name]) ?>
            </div>

            <div class="prevs">

                <div id="item-prev">
                    <?php
                    if (count($model->photos) > 1) {

                        foreach ($model->photos as $photo) {
                            ?>
                            <img src="<?="/".$photo->doCache('481x481', 'auto', '481x481')?>" />
                        <?php
//                            echo Html::img("/".$photo->doCache('481x481', 'auto', '481x481'));
                        }
                    }
                    ?>
                </div>
                <div id="item-prev-up"></div>
                <div id="item-prev-down"></div>
            </div>
        </div>
        <?php
        }
        ?>

        <div class="info">

            <div class="price">
                <span class="one-item"><?=$model->price?></span>
                <div class="sub">-</div>
                <input id="item-count" type="text" value="1" name="count">
                <div class="add">+</div>
                <span class="calc-price"></span>
            </div>

            <div class="chars">
                <?= $this->render('_product_property', ['model' => $model]) ?>
            </div>

            <div class="buttons">
                <input type="button" value="В корзину" class="add-to-cart-button" var-href="<?=\yii\helpers\Url::to(['/add-to-cart', 'id' => $model->getPrimaryKey()])?>">
                <input type="button" value="Избранное" class="fav" var-prod="<?=$model->getPrimaryKey()?>">
            </div>

            <div class="description">
                <?=$model->description?>
            </div>

            <div class="share">
                <div class="socials">
                    <span>Поделиться</span>
                    <a class="i vk"></a>
                    <a class="i fb"></a>
                    <a class="i tw"></a>
                    <a class="i ok"></a>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Просмотренный товар -->
<section class="category">
    <div class="container">

        <div class="title-last">
            <h1 class="last">Последние просмотры</h1>
            <h1>Смотрите также</h1>
        </div>

        <div class="items watched-carousel">

            <?php
            $cookie = \Yii::$app->request->cookies->get('i_saw_this_product');

            $ids = unserialize($cookie->value);

            $all = \common\modules\catalog\models\Product::find()->where('id in (' . implode(',', $ids) . ')')->all();

            foreach ($all as $_prod) {
            ?>
                <div class="item">
                    <?php
//                    if (!empty($_prod->photos[0]))
                        echo Html::img("/".$_prod->photos[0]->doCache('200x200', 'auto'));
                    ?>
                    <span><?=$_prod->h1_name?></span>
                    <?=Html::a('Подробнее', ['/' . $_prod->id. "/".\common\helpers\CString::translitTo($_prod->h1_name)], ['class' => 'hov'])?>
                </div>
            <?php
            }
            ?>
        </div>

        <span id="watched-car-prev"></span>
        <span id="watched-car-next"></span>
    </div>
</section>