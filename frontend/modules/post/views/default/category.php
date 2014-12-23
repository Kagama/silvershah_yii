<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 24.06.14
 * Time: 20:16
 */
?>
<div class="orange-white-delimiter">
    <div class="margin03percent">
        <img src="/img/news-icon.png" class="icon-bg" alt="Информационные сообщения" /> <span><a href="<?= \yii\helpers\Url::toRoute('/'.$menu->url); ?>">Все новости</a> - <?= $category->name ?></span>
    </div>
</div>
<div class="row white-bg" style="background-color: #f4f4f4;">

    <div class="margin03percent">
        <div class="col-lg-17">
            <?=
            \yii\widgets\ListView::widget([
                'dataProvider' => $dataProvider,
                'layout' => '{items}{pager}',
                'itemView' => '_news_item',
                'emptyText' => '- Нет новостей -',
                'viewParams' => ['menu' => $menu],
                'showOnEmpty' => '-',
                'itemOptions' => [
                    'tag' => 'article'
                ],
                'pager' => [
                    'prevPageLabel' => '&nbsp;',
                    'nextPageLabel' => '&nbsp;'
                ]
            ])
            ?>
        </div>

    </div>
</div>