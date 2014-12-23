<?php
/**
 * @var yii\web\View $this
 */
$this->title = 'Главная';


$this->title = Yii::$app->params['seo_title'];
Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->params['seo_keywords']]);
Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => Yii::$app->params['seo_description']]);
?>
    <!-- Slider -->
    <section id="slider">
        <div class="container">

            <!-- Блок слайдера -->
            <div id="slideshow" class="slider">

                <!-- Слайд -->
                <div class="slide">

                    <!-- Картинка слайда, позиционируется абсолютно, в верхний правый угол-->
                    <img src="/img/slides/1.png" />

                    <!-- Информация слайда -->
                    <div class="inf">
                        <!-- Название товара -->
                        <h1>Винный сервиз из серебра</h1>
                        <!-- Цена -->
                        <span class="slide-price">384 000,-</span>
                        <!-- Информация -->
                        <div class="info">Информация о товаре (уточнить формат)</div>
                    </div>
                </div>

                <div class="slide">
                    <div class="inf">
                        <img src="/img/slides/1.png" />
                        <h1>Винный сервиз из золота</h1>
                        <span class="slide-price">569 800,-</span>
                        <div class="info">Информация о товаре (уточнить формат)</div>
                    </div>
                </div>

                <div class="slide">
                    <div class="inf">
                        <img src="/img/slides/1.png" />
                        <h1>Винный сервиз из межпространственного вакуума</h1>
                        <span class="slide-price">-58 000,-</span>
                        <div class="info">Информация о товаре (уточнить формат)</div>
                    </div>
                </div>

                <div id="prev"></div>
                <div id="next"></div>

            </div>
        </div>
    </section>


<?php
$categories = \common\modules\catalog\models\ProductCategory::find()->where(['parent_id' => null])->orderBy('position, level ASC ')->all();

foreach ($categories as $cat) {
    ?>
    <!-- Категории товара -->
    <section class="category">
        <div class="container">
            <div class="title">
                <div class="icon <?=$cat->getCssClassName();?>"></div>
                <h1><?=($cat->children == null ? \yii\helpers\Html::a($cat->h1, ['/'.$cat->prepareUrl()]) : $cat->h1)?></h1>
            </div>
            <div class="items">
                <?php
                    foreach ($cat->children as $child_cat) {
                        ?>
                        <div class="item">
                            <?//=\yii\helpers\Html::img($child_cat->doCache('180x180', 'auto', '180x180'), ['alt' => 'фото категории - '.$child_cat->name])?>
                            <span><?=$child_cat->h1?></span>
                            <a class="hov" href="<?=\yii\helpers\Url::to(['/'.$child_cat->prepareUrl()])?>">
                                Подробнее
                            </a>
                        </div>
                    <?php
                    }
                ?>
            </div>
        </div>
    </section>
    <!-- конец вывода -->
<?php
}
?>