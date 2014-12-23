<?php
/**
 * @var yii\web\View $this
 */
$this->title = 'Главная';
?>
<!-- category-and-slider -->
<div style="background-color: #f9f9f9; padding-bottom: 60px;">


<div class="row no-padding-no-margin category-and-slider">
    <div class="align-center">
        <div class="col-lg-3 no-padding-no-margin">
            <?php
            echo \frontend\modules\catalog\widgets\CategoryWidget::widget();
            ?>
            <!--            <ul class="catalog-category">-->
            <!--                <li><a href="#">Компьютеры и ноутбуки (125)</a></li>-->
            <!--                <li><a href="#">Портативная техника (125)</a></li>-->
            <!--                <li><a href="#">ТВ и Развлечения (125)</a></li>-->
            <!--                <li><a href="#">Периферия (125)</a></li>-->
            <!--                <li><a href="#">Сети и Кабели (125)</a></li>-->
            <!--                <li><a href="#">Техника для кухни (125)</a></li>-->
            <!--                <li><a href="#">Техника для дома (125)</a></li>-->
            <!--                <li><a href="#">Планшетные ПК (125)</a></li>-->
            <!--                <li><a href="#">Моноблоки (125)</a></li>-->
            <!--            </ul>-->
        </div>
        <div class="col-lg-9 no-padding-no-margin">
            <div class="row no-padding-no-margin">
                <div class="col-lg-12 no-padding-no-margin" style="margin-left: 10px">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                            <div class="item active">
                                <a href="/"><img src="/images/modules/slider/slider-1.png" alt=""></a>
                            </div>
                            <div class="item">
                                <a href="#"><img src="/images/modules/slider/slider-1.png" alt=""></a>
                            </div>
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
                </div>
                <div class="col-lg-12 just-sell-block">
                    <span class="block-title">Только что проданно</span>

                    <div class="just-sell">

                        <a href="#" class="left">&nbsp;</a>
                        <a href="#" class="right">&nbsp;</a>

                        <div class="content">
                            <ul>
                                <li>
                                    <img src="/img/just-sell-img1.png" alt="just-sell-img1.png"/>

                                    <div class="prod-info">
                                        <a href="#">Ноутбук Apple MacBook Pro 15"</a>
                                        <span class="price">93 610 p.</span> <span class="time">1ч. 3 мин.</span>
                                    </div>
                                </li>
                                <li>
                                    <img src="/img/just-sell-img1.png" alt="just-sell-img1.png"/>

                                    <div class="prod-info">
                                        <a href="#">Ноутбук Apple MacBook Pro 15"</a>
                                        <span class="price">93 610 p.</span> <span class="time">1ч. 3 мин.</span>
                                    </div>
                                </li>
                                <li>
                                    <img src="/img/just-sell-img1.png" alt="just-sell-img1.png"/>

                                    <div class="prod-info">
                                        <a href="#">Ноутбук Apple MacBook Pro 15"</a>
                                        <span class="price">93 610 p.</span> <span class="time">1ч. 3 мин.</span>
                                    </div>
                                </li>
                                <li>
                                    <img src="/img/just-sell-img1.png" alt="just-sell-img1.png"/>

                                    <div class="prod-info">
                                        <a href="#">Ноутбук Apple MacBook Pro 15"</a>
                                        <span class="price">93 610 p.</span> <span class="time">1ч. 3 мин.</span>
                                    </div>
                                </li>
                                <li>
                                    <img src="/img/just-sell-img1.png" alt="just-sell-img1.png"/>

                                    <div class="prod-info">
                                        <a href="#">Ноутбук Apple MacBook Pro 15"</a>
                                        <span class="price">93 610 p.</span> <span class="time">1ч. 3 мин.</span>
                                    </div>
                                </li>
                                <li>
                                    <img src="/img/just-sell-img1.png" alt="just-sell-img1.png"/>

                                    <div class="prod-info">
                                        <a href="#">Ноутбук Apple MacBook Pro 15"</a>
                                        <span class="price">93 610 p.</span> <span class="time">1ч. 3 мин.</span>
                                    </div>
                                </li>
                                <li>
                                    <img src="/img/just-sell-img1.png" alt="just-sell-img1.png"/>

                                    <div class="prod-info">
                                        <a href="#">Ноутбук Apple MacBook Pro 15"</a>
                                        <span class="price">93 610 p.</span> <span class="time">1ч. 3 мин.</span>
                                    </div>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- конец category-and-slider -->
<!-- товар для и супер цена -->
<div class="row no-padding-no-margin" style="padding-top: 20px;">
    <div class="align-center">
        <div class="col-lg-4 no-padding-no-margin" style="width: 30%;">
            <div class="product-of-the-day">
                <span class="title">Товар дня</span>

                <div class="text-center">
                    <img src="/img/just-sell-img1-medium.png"/>
                    <a href="#" class="prod-link">Ноутбук Apple MacBook Pro 15" Early 2013 ME664C216GRU/A</a>

                    <div class="row no-padding-no-margin" style="margin: 0 9%;">
                        <div class="col-lg-6 text-left no-padding-no-margin">
                            <span class="old-price"><s>102 610 р.</s></span>
                            <span class="price">93 610 р.</span>
                        </div>
                        <div class="col-lg-6 no-padding-no-margin">
                            <a href="#" class="add-to-cart-red">В конзину</a>
                        </div>
                        <span class="col-lg-12 left-prod-count no-padding-no-margin text-left">
                            Осталось <strong>8 шт.</strong>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 no-padding-no-margin super-price-block">
            <span class="title">Суперцена!!!</span>

            <div class="super-price">
                <a class="left" href="#"></a>
                <a class="right" href="#"></a>

                <div class="content">
                    <ul>
                        <li class="text-center">
                            <img src="/img/prod/prod-1.png"/>
                            <a href="#" class="prod-link">Сотовый телефон Fly IQ4403 Energie 3 Black</a>

                            <div class="row no-padding-no-margin">
                                <div class="col-lg-6 text-left no-padding-no-margin">
                                    <span class="old-price"><s>102 610 р.</s></span>
                                    <span class="price">93 610 р.</span>
                                </div>
                                <div class="col-lg-6 no-padding-no-margin">
                                    <a href="#" class="add-to-cart-red">В конзину</a>
                                </div>
                            </div>
                        </li>
                        <li class="text-center">
                            <img src="/img/prod/prod-1.png"/>
                            <a href="#" class="prod-link">Сотовый телефон Fly IQ4403 Energie 3 Black</a>

                            <div class="row no-padding-no-margin">
                                <div class="col-lg-6 text-left no-padding-no-margin">
                                    <span class="old-price"><s>102 610 р.</s></span>
                                    <span class="price">93 610 р.</span>
                                </div>
                                <div class="col-lg-6 no-padding-no-margin">
                                    <a href="#" class="add-to-cart-red">В конзину</a>
                                </div>
                            </div>
                        </li>
                        <li class="text-center">
                            <img src="/img/prod/prod-1.png"/>
                            <a href="#" class="prod-link">Сотовый телефон Fly IQ4403 Energie 3 Black</a>

                            <div class="row no-padding-no-margin">
                                <div class="col-lg-6 text-left no-padding-no-margin">
                                    <span class="old-price"><s>102 610 р.</s></span>
                                    <span class="price">93 610 р.</span>
                                </div>
                                <div class="col-lg-6 no-padding-no-margin">
                                    <a href="#" class="add-to-cart-red">В конзину</a>
                                </div>
                            </div>
                        </li>
                        <li class="text-center">
                            <img src="/img/prod/prod-1.png"/>
                            <a href="#" class="prod-link">Сотовый телефон Fly IQ4403 Energie 3 Black</a>

                            <div class="row no-padding-no-margin">
                                <div class="col-lg-6 text-left no-padding-no-margin">
                                    <span class="old-price"><s>102 610 р.</s></span>
                                    <span class="price">93 610 р.</span>
                                </div>
                                <div class="col-lg-6 no-padding-no-margin">
                                    <a href="#" class="add-to-cart-red">В конзину</a>
                                </div>
                            </div>
                        </li>
                        <li class="text-center">
                            <img src="/img/prod/prod-1.png"/>
                            <a href="#" class="prod-link">Сотовый телефон Fly IQ4403 Energie 3 Black</a>

                            <div class="row no-padding-no-margin">
                                <div class="col-lg-6 text-left no-padding-no-margin">
                                    <span class="old-price"><s>102 610 р.</s></span>
                                    <span class="price">93 610 р.</span>
                                </div>
                                <div class="col-lg-6 no-padding-no-margin">
                                    <a href="#" class="add-to-cart-red">В конзину</a>
                                </div>
                            </div>
                        </li>
                        <li class="text-center">
                            <img src="/img/prod/prod-1.png"/>
                            <a href="#" class="prod-link">Сотовый телефон Fly IQ4403 Energie 3 Black</a>

                            <div class="row no-padding-no-margin">
                                <div class="col-lg-6 text-left no-padding-no-margin">
                                    <span class="old-price"><s>102 610 р.</s></span>
                                    <span class="price">93 610 р.</span>
                                </div>
                                <div class="col-lg-6 no-padding-no-margin">
                                    <a href="#" class="add-to-cart-red">В конзину</a>
                                </div>
                            </div>
                        </li>
                        <li class="text-center">
                            <img src="/img/prod/prod-1.png"/>
                            <a href="#" class="prod-link">Сотовый телефон Fly IQ4403 Energie 3 Black</a>

                            <div class="row no-padding-no-margin">
                                <div class="col-lg-6 text-left no-padding-no-margin">
                                    <span class="old-price"><s>102 610 р.</s></span>
                                    <span class="price">93 610 р.</span>
                                </div>
                                <div class="col-lg-6 no-padding-no-margin">
                                    <a href="#" class="add-to-cart-red">В конзину</a>
                                </div>
                            </div>
                        </li>

                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- конец товар для и супер цена -->
<!-- Продвигаемая продукция -->
<?=
\frontend\modules\catalog\widgets\PromoProductWidget::widget([
]);
?>
<!-- Конец Продвигаемая продукция -->
<!-- Новости и соц сети -->
<div class="row no-padding-no-margin" style="margin-top: 30px;">
    <div class="align-center">
        <div class="col-lg-6">
            <?=\frontend\modules\news\widget\NewsWidget::widget()?>

        </div>
        <div class="col-lg-3">
            Facebook Социальная сеть
        </div>
        <div class="col-lg-3">
            VK Социальная сеть
        </div>
    </div>
</div>
<!-- Конец Новости и соц сети -->
<!-- -->
<!-- -->
<!-- -->
<!-- -->
<!-- -->

</div>