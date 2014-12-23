<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="<?= Yii::$app->language ?>"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" lang="<?= Yii::$app->language ?>"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" lang="<?= Yii::$app->language ?>"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="<?= Yii::$app->language ?>"> <!--<![endif]-->
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="/favicon.ico?v=2" type="image/x-icon">
    <link rel="icon" href="/favicon.ico?v=2" type="image/x-icon">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<!--[if lt IE 7]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->

<!-- Add your site or application content here -->


<?php $this->beginBody() ?>
<!-- Header -->
<header>
    <div class="container">
        <a href="/"><img src="/img/logo.png" alt=""></a>

        <div class="r">
            <nav class="wide">
                <?php
                echo \common\modules\menu\widget\frontend\MenuWidget::widget([
                    'menu_group' => 1
                ]);
                ?>
            </nav>

            <div class="tel">
                <span>8 (800) 234-31-36</span>
                <br/>
                <span>8 (495) 773-31-36</span>
            </div>

            <div class="opt">
                <a class="fav item" href="<?=\yii\helpers\Url::to(['/favorite'])?>"></a>
                <div class="cart item">
                    <?= \frontend\modules\cart\widget\UserCartWidget::widget(); ?>
                </div>
            </div>

            <div class="nar_menu_button"></div>

        </div>

    </div>

</header>
<nav class="narrow">
    <?php
    echo \common\modules\menu\widget\frontend\MenuWidget::widget([
        'menu_group' => 1
    ]);
    ?>
</nav>

<!-- Корзина -->
<noindex>
    <section class="cart-section">
<!--        --><?php //\yii\widgets\Pjax::begin([
//            'timeout' => 1000,
//            'clientOptions'=>[
//                'container'=>'form1',
//            ]
//        ])?>
        <?= \frontend\modules\cart\widget\CartContent::widget() ?>
<!--        --><?php //\yii\widgets\Pjax::end()?>
    </section>
</noindex>

<!-- Groups -->
<section class="menu-groups">
    <div class="container">
        <nav class="menu">
            <?php
            echo \frontend\modules\catalog\widgets\CategoryWidget::widget();
            ?>
        </nav>
    </div>

    <div class="cur" id="main-cur"></div>

    <div class="categories">

        <div class="container">
            <nav id="cat-menu">

                <ul></ul>

            </nav>
        </div>

        <div class="close"></div>

    </div>
</section>




<?= $content ?>


<!-- Socials -->
<div class="socials">
    <a class="i vk"></a>
    <a class="i fb"></a>
    <a class="i tw"></a>
    <a class="i ok"></a>
</div>


<!-- Footer -->
<footer>
    <div class="container">

        <nav>
            <?php
            echo \common\modules\menu\widget\frontend\MenuWidget::widget([
                'menu_group' => 1
            ]);
            ?>
            <!--            <ul>-->
            <!--                <li><a href="#">О компании</a></li>-->
            <!--                <li><a href="#">Общие сведения</a></li>-->
            <!--                <li><a href="#">Статьи</a></li>-->
            <!--                <li><a href="#">Новости</a></li>-->
            <!--                <li><a href="#">Как купить</a></li>-->
            <!--                <li><a href="#">Доставка</a></li>-->
            <!--                <li><a href="#">Контакты</a></li>-->
            <!--            </ul>-->
        </nav>

        <nav class="groups">
            <ul>
                <li><a href="#">Подарки из сербра</a></li>
                <li><a href="#">Кубачинское серебро</a></li>
                <li><a href="#">Серебряная посуда</a></li>
                <li><a href="#">Сервизы и наборы</a></li>
                <li><a href="#">Оружие из серебра</a></li>
                <li><a href="#">Эксклюзивная работа</a></li>
                <li><a href="#">Антиквариат</a></li>
            </ul>
        </nav>

        <div class="tel">
            <span>&nbsp;&nbsp;8(800) 234-31-36</span>

            <span>+7(495) 773-31-36</span>
        </div>

        <img src="/img/logo.png" alt="">

        <div class="tel">
            <span>+7(916) 374-01-46</span>

            <span>+7(916) 573-53-62</span>
        </div>

    </div>
</footer>

<!-- JavaScripts -->
<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
