<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <?php
        foreach ($models as $index => $model) {
        ?>
            <div class="item <?=($index == 0 ? "active" : "" )?>">
                <?=\yii\helpers\Html::a(\yii\helpers\Html::img("/".$model->doCache('698x268', 'height')), $model->href, ['target' => "_blank"])?>
            </div>
        <?php
        }
        ?>
    </div>
    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-example-generic" role="button"
       data-slide="prev">
        <span class="carousel-control-left-bg"></span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" role="button"
       data-slide="next">
        <span class="carousel-control-right-bg"></span>
    </a>
</div>