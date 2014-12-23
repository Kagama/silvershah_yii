<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 30.06.14
 * Time: 16:27
 */

use yii\web\View;
use yii\widgets\Breadcrumbs;


Yii::$app->view->registerJs('


    $(document).on("change", ".property_values input", function(){
        $(".product-filter-widget").submit();
    });

    // Изменение отображения продуктов
    $(document).on("click", ".product-render-type a", function(){
        $(".product-render-type a").each(function(){
            $(this).removeClass("active");
        });
        if ($(this).hasClass("block")) {
            $(".product-list").removeClass("products-like-list");
            $(".product-list").addClass("products-like-block");
            $.cookie("product-render-type", "block", { expires: 120, path: "/" });
        }
        if ($(this).hasClass("list")) {
            $(".product-list").removeClass("products-like-block");
            $(".product-list").addClass("products-like-list");
            $.cookie("product-render-type", "list", { expires: 120, path: "/" });
        }
        $(this).addClass("active");

        return false;
    });

    // Инициализация вида отображения продукта
    function setRenderType ()
    {
        if ($.cookie("product-render-type")) {
            if ($.cookie("product-render-type") == "block") {
                $(".product-render-type a").each(function(){
                    $(this).removeClass("active");
                });
                $(".product-render-type a.block").addClass("active");
                $(".product-list").removeClass("products-like-list");
                $(".product-list").addClass("products-like-block");
            }
            if ($.cookie("product-render-type") == "list") {
                $(".product-render-type a").each(function(){
                    $(this).removeClass("active");
                });
                $(".product-render-type a.list").addClass("active");
                $(".product-list").removeClass("products-like-block");
                $(".product-list").addClass("products-like-list");
            }
        } else {
            $(".product-list").addClass("products-like-block");
        }
    }

    // Вызов после стандартного запуска страницы
    setRenderType();

    // Действие после выполнения запроса PJAX
    $(document).on("pjax:end", function() {
        setRenderType();
        $("#loader").hide();
    })

    $(document).on("pjax:start", function(){
        $("#loader").show();
    });

', View::POS_END, 'product-list-page');

$this->params['breadcrumbs'] = [
    ['label' => $category->name, 'url' => null],
];

$this->title = $category->name . " - " . Yii::$app->params['seo_title'];
Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => $category->seo_keywords]);
Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => $category->seo_description]);
?>

<div class="row no-padding-no-margin products-list" style="background-color: #fff;">
    <div id="loader"></div>
    <?php \yii\widgets\Pjax::begin(); ?>

    <div class="align-center">

        <div class="col-lg-9 no-padding-no-margin">

            <div style="font-size: 12px;">
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
            </div>
            <h1><?= $category->name ?></h1>

            <div class="product-render-type">
                <a href="#" class="list ">&nbsp;</a> <a href="#" class="block active">&nbsp;</a>
            </div>
            <p>
                <?= $category->text_before ?>
            </p>

            <div class="product-list" style="margin-right: 25px;">

                <?=
                \yii\widgets\ListView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => '<div>
                                        <div class="total">Всего в категории <span>' . $dataProvider->getTotalCount() . '</span> наименования</div>
                                        <span class="sorter-block">Сортировать по: {sorter}</span>
                                </div> {items} <div class="pagination-container">{pager}</div>',
                    'itemView' => '../default/_product_item',
                    'emptyText' => '- Нет продуктов -',
//            'viewParams' => ['category' => $menu],
                    'showOnEmpty' => '-',
                    'itemOptions' => [
                        'tag' => 'div',
                        'class' => 'product-item',
                        'data-pjax' => '1'
                    ],
                    'pager' => [
                        'prevPageLabel' => '&laquo;',
                        'nextPageLabel' => '&raquo;'
                    ]
                ])
                ?>
            </div>
            <p>
                <?= $category->text_after ?>
            </p>
        </div>
        <div class="col-lg-3 no-padding-no-margin">

<!--            --><?//= \frontend\modules\catalog\widgets\PropertyFilterWidget::widget([
//                'product_type' => $product_type,
//                'category' => $category
//            ]); ?>

        </div>
        <?php \yii\widgets\Pjax::end(); ?>
    </div>
</div>

