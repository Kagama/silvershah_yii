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

    $this->title = "Избранное" . " - " . Yii::$app->params['seo_title'];
    Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->params['seo_keywords']]);
    Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => Yii::$app->params['seo_description']]);
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
            }
            ?>
        </div>
    </div>
</section>

<!-- Категории товара -->
<section class="category">
    <div class="container">
        <!--        <div class="items">-->
        <?php
        if ($dataProvider != null) {
            echo \yii\widgets\ListView::widget([
                'dataProvider' => $dataProvider,
                'layout' => '{items} <div class="pagination-container">{pager}</div>',
                'itemView' => '_product_item',
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
            ]);
        } else {
            ?>
            <p>Нет данных</p>
        <?php
        }

        ?>
    </div>
</section>
