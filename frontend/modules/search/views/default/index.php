<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 14.08.14
 * Time: 18:55
 */
$this->params['breadcrumbs'] = [
    ['label' => 'Поиск', 'url' => null],
];
?>
<div class="row no-padding-no-margin products-list" style="background-color: #fff">
    <div class="align-center">
        <div class="row no-padding-no-margin">
            <div class="col-lg-9 no-padding-no-margin">
                <div class="show-new-page" style="font-size: 12px;">
                    <div style="font-size: 12px;">
                        <?=
                        \yii\widgets\Breadcrumbs::widget([
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            'encodeLabels' => false
                        ]) ?>
                    </div>
                    <h1 class="title">Результат поиска</h1>

                    <div class="product-list products-like-list" style="margin-right: 25px;">
                        <?=
                        \yii\widgets\ListView::widget([
                            'dataProvider' => $dataProvider,
                            'layout' => '<div><div class="total">Всего в категории <span>' . $dataProvider->getTotalCount() . '</span> наименования</div> <span class="sorter-block">Сортировать по: {sorter}</span></div> {items} <div class="pagination-container">{pager}</div>',
                            'itemView' => '_search',
                            'emptyText' => '- Нет продуктов -',
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
            <div class="col-lg-3 no-padding-no-margin">
                <?=
                \frontend\modules\catalog\widgets\PromoProductWidget::widget([
                    'prod_of_the_day' => 1,
                    'limit' => 1
                ]);
                ?>
                <div class="clearfix">&nbsp;</div>
                <?=
                \frontend\modules\catalog\widgets\PromoProductWidget::widget([
                    'view_type' => \frontend\modules\catalog\widgets\PromoProductWidget::VIEW_BLOCK,
                    'limit' => 4
                ]);
                ?>
            </div>
        </div>

    </div>
</div>