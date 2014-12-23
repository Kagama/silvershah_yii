<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 30.06.14
 * Time: 16:27
 */

use yii\web\View;
use yii\widgets\Breadcrumbs;


//Yii::$app->view->registerJs('
//
//
//    $(document).on("change", ".property_values input", function(){
//        $(".product-filter-widget").submit();
//    });
//
//    // Изменение отображения продуктов
//    $(document).on("click", ".product-render-type a", function(){
//        $(".product-render-type a").each(function(){
//            $(this).removeClass("active");
//        });
//        if ($(this).hasClass("block")) {
//            $(".product-list").removeClass("products-like-list");
//            $(".product-list").addClass("products-like-block");
//            $.cookie("product-render-type", "block", { expires: 120, path: "/" });
//        }
//        if ($(this).hasClass("list")) {
//            $(".product-list").removeClass("products-like-block");
//            $(".product-list").addClass("products-like-list");
//            $.cookie("product-render-type", "list", { expires: 120, path: "/" });
//        }
//        $(this).addClass("active");
//
//        return false;
//    });
//
//    // Инициализация вида отображения продукта
//    function setRenderType ()
//    {
//        if ($.cookie("product-render-type")) {
//            if ($.cookie("product-render-type") == "block") {
//                $(".product-render-type a").each(function(){
//                    $(this).removeClass("active");
//                });
//                $(".product-render-type a.block").addClass("active");
//                $(".product-list").removeClass("products-like-list");
//                $(".product-list").addClass("products-like-block");
//            }
//            if ($.cookie("product-render-type") == "list") {
//                $(".product-render-type a").each(function(){
//                    $(this).removeClass("active");
//                });
//                $(".product-render-type a.list").addClass("active");
//                $(".product-list").removeClass("products-like-block");
//                $(".product-list").addClass("products-like-list");
//            }
//        } else {
//            $(".product-list").addClass("products-like-block");
//        }
//    }
//
//    // Вызов после стандартного запуска страницы
//    setRenderType();
//
//    // Действие после выполнения запроса PJAX
//    $(document).on("pjax:end", function() {
//        setRenderType();
//        $("#loader").hide();
//    })
//
//    $(document).on("pjax:start", function(){
//        $("#loader").show();
//    });
//
//', View::POS_END, 'product-list-page');

if ($category != null) {
    $this->params['breadcrumbs'] = [
        ['label' => $category->name, 'url' => null],
    ];

    $this->title = $category->name . " - " . Yii::$app->params['seo_title'];
    Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => $category->seo_keywords]);
    Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => $category->seo_description]);
} else {
    $this->title = "Избранное" . " - " . Yii::$app->params['seo_title'];
    Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->params['seo_keywords']]);
    Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => Yii::$app->params['seo_description']]);
}




?>

<!-- Filter -->
<section class="filter">
    <div class="container">

        <div class="title">
            <?php
            if ($category == "") {
                ?>
                <span>Избранное</span>
                <?php
            } else if ($category->parent_id == null) {
                ?>
                <span><?=$category->h1?></span>
            <?php
            } else {
                ?>
                <span><?=$category->h1?></span>
            <?php
            }
            ?>

        </div>

        <form action="" method="get">

            <div class="search">
                <label for="">Поиск</label>
                <input type="text" name="PropertyFilter[search-text]" value="<?=(isset($PropertyFilter['search-text']) ? $PropertyFilter['search-text'] : "" )?>">
            </div>
            <?php
            $min_price = 500;
            $max_price = 20000000;

            if ($priceRange != null) {
                $max_price = (int) $priceRange['max_price'];
                $min_price = (int) $priceRange['min_price'];
            }
            ?>
            <div class="price">
                <label for="">Цена</label>
                <div class="range-slider" data-range_min="<?=$min_price?>" data-range_max="<?=$max_price?>"
                     data-cur_min="<?=(isset($PropertyFilter['price']['min']) ? $PropertyFilter['price']['min'] : $min_price )?>"    data-cur_max="<?=(isset($PropertyFilter['price']['max']) ? $PropertyFilter['price']['max'] : $max_price )?>">
<!--                     <div class="bgbar"></div>-->
                    <div class="bar"></div>
                    <div class="lg"></div>
                    <div class="rg"></div>
                </div>

                <input  class="range range-price-min" name="PropertyFilter[price][min]" type="text" value="<?=(isset($PropertyFilter['price']['min']) ? $PropertyFilter['price']['min'] : $min_price )?>">
                &#8211;
                &nbsp;
                <input class="range range-price-max" name="PropertyFilter[price][max]" type="text" value="<?=(isset($PropertyFilter['price']['max']) ? $PropertyFilter['price']['max'] : $max_price )?>">

<!--                <div class="ch up"></div>-->
<!--                <div class="ch down"></div>-->

                <input type="submit" value="Показать">
            </div>

        </form>

    </div>
</section>

<!-- Категории товара -->
<section class="category">
    <div class="container">
<!--        <div class="items">-->
            <?=
            \yii\widgets\ListView::widget([
                'dataProvider' => $dataProvider,
                'layout' => '{items}<br style="clear: both;" />{pager}',
                'itemView' => '../default/_product_item',
                'emptyText' => '- Нет продуктов -',
//                'viewParams' => ['productViewStyle' => $productViewStyle],
                'showOnEmpty' => '-',
                'itemOptions' => [
                    'tag' => false,
//                    'data-pjax' => '0'
                ],
                'options' => [
                    'class' => 'items'
                ],

                'pager' => [
                    'prevPageLabel' => '&laquo;',
                    'nextPageLabel' => '&raquo;'
                ]
            ])
            ?>
    </div>
</section>
<section>
    <div class="container" style="width: 70%;">
        <p>
            <?= $category->text_before ?>
        </p>
        <p>
            <?= $category->text_after ?>
        </p>
    </div>
</section>
