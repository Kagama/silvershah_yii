<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 25.07.14
 * Time: 17:23
 */
use yii\widgets\Breadcrumbs;
use yii\web\View;
Yii::$app->view->registerJs('
    $(".product-render-type a").on("click", function(){
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

', View::POS_END, 'product-list-page');

$this->params['breadcrumbs'] = [
    ['label' => $promotionModel->name, 'url' => null],
];
?>
<div class="row no-padding-no-margin products-list" style="background-color: #f4f4f4">
    <div class="align-center">
        <div class="col-lg-12 no-padding-no-margin">
            <div style="font-size: 12px;">
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
            </div>
            <div class="product-render-type">
                <a href="#" class="list ">&nbsp;</a> <a href="#" class="block active">&nbsp;</a>
            </div>
            <h1><?= $promotionModel->name; ?></h1>

            <div class="product-list">
                <?=
                \yii\widgets\ListView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => '<div><div class="total">Всего товаров <span>' . $dataProvider->getTotalCount() . '</span> наименования</div> <span class="sorter-block">Сортировать по: {sorter}</span></div> {items} <div class="pagination-container">{pager}</div>',
                    'itemView' => '../default/_product_item',
                    'emptyText' => '- Нет продуктов -',
//            'viewParams' => ['category' => $menu],
                    'showOnEmpty' => '-',
                    'itemOptions' => [
                        'tag' => 'div',
                        'class' => 'product-item'
                    ],
                    'pager' => [
                        'prevPageLabel' => '&laquo;',
                        'nextPageLabel' => '&raquo;'
                    ]
                ])
                ?>
            </div>
        </div>
    </div>
</div>