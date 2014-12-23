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
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <!--    <meta name="viewport" content="width=device-width, initial-scale=1">-->
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?php
/* NavBar::begin([
     'brandLabel' => 'My Company',
     'brandUrl' => Yii::$app->homeUrl,
     'options' => [
         'class' => 'navbar-inverse navbar-fixed-top',
     ],
 ]);
 $menuItems = [
     ['label' => 'Home', 'url' => ['/site/index']],
     ['label' => 'About', 'url' => ['/site/about']],
     ['label' => 'Contact', 'url' => ['/site/contact']],
 ];
 if (Yii::$app->user->isGuest) {
     $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
     $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
 } else {
     $menuItems[] = [
         'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
         'url' => ['/site/logout'],
         'linkOptions' => ['data-method' => 'post']
     ];
 }
 echo Nav::widget([
     'options' => ['class' => 'navbar-nav navbar-right'],
     'items' => $menuItems,
 ]);
 NavBar::end();
*/
?>

<div id="head" class="container-fluid">
    <div class="row head-top no-padding-no-margin">
        <div class="align-center">
            <div class="col-lg-7 no-padding-no-margin" style="z-index: 10;">
                <?php
                $css = ( (Yii::$app->controller->uniqueId == 'catalog/default' &&
                    Yii::$app->controller->action->id == 'index')  ? '' : 'style="opacity:1;"');
                ?>
                <a href="#" class="catalog-button-top" <?=$css?>>Каталог товаров</a>
                <div class="catalog-top-block"><noindex>
                    <?php
                    echo \frontend\modules\catalog\widgets\CategoryWidget::widget();
                    ?></noindex>
                </div>
            </div>
            <div class="col-lg-3 no-padding-no-margin">
                <?= \frontend\modules\cart\widget\UserCartWidget::widget(); ?>
            </div>
            <div class="col-lg-2 no-padding-no-margin login-registration text-right">
                <?=\frontend\modules\user\widget\UserLoginRegistrationWidget::widget(); ?>
            </div>
        </div>
    </div>
    <div class="row head-bottom no-padding-no-margin">
        <div class="align-center">
            <div class="col-lg-2 no-padding-no-margin">
                <?= Html::a(Html::img('/img/logo.gif', ['alt' => 'Лого - Компания Квадро', 'class' => 'logo']), '/') ?>
            </div>
            <div class="col-lg-7 no-padding-no-margin" style="padding-left: 30px;">
                <!--                    <div class="row">-->
                <ul class="col-lg-12 top-menu">
                    <li><?= Html::a('Новости', ['/news/all']); ?></li>
<!--                    <li>--><?//= Html::a('Блог', ['/blog/all']); ?><!--</li>-->
                    <li><?= Html::a('Доставка', ['/dostavka']); ?></li>
                    <li class="last"><?= Html::a('Оплата', ['/oplata']); ?></li>
                </ul>
                <div class="col-lg-12">
                    <?php $form = \yii\widgets\ActiveForm::begin([
                        'action' => ['/search'],
                        'method' => 'get',
                        'options' => [
                            'class' => 'search-form'
                        ]
                    ]); ?>
                    <span class="left">
                                <span class="right">
                                    <?= Html::textInput('search_text', Yii::$app->request->get('search_text'), ['placeholder' => 'Введите фразу поиска', 'class' => 'search-text']) ?>
                                </span>
                            </span>

                    <?= Html::submitButton('Найти', ['class' => 'search-button']) ?>
                    <p class="hint">Например: <span>ноутбук Asus</span></p>
                    <?php \yii\widgets\ActiveForm::end(); ?>
                </div>
                <!--                    </div>-->
            </div>
            <div class="col-lg-3 no-padding-no-margin">
                <div class="contact-info">

                </div>
                <div class="contact-info-content">
<!--                    <span class="address">г. Махачкала ул. Хизроева 70 "Б"</span>-->
                    <span class="phone"><span></span>550-777</span>
                </div>

            </div>
        </div>
    </div>

</div>
<?= $content ?>
<div class="wrap">
    <div class="container align-center">
        <!--        --><? //= Breadcrumbs::widget([
        //            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        //        ])
        ?>
        <!--        --><? //= Alert::widget() ?>
    </div>
</div>

<div class="row no-padding-no-margin" id="foot">
    <div class="align-center">
        <div class="col-lg-3 no-padding-no-margin copy">
            2014 г. © Компания «Квадро»<br/>Все права защищены
        </div>
        <div class="col-lg-6 no-padding-no-margin">
            <ul class="col-lg-12 top-menu">
                <li><?= Html::a('Новости', ['/news/all']); ?></li>
<!--                <li>--><?//= Html::a('Блог', ['/blog/all']); ?><!--</li>-->
                <li><?= Html::a('Доставка', ['/delivery']); ?></li>
                <li class="last"><?= Html::a('Оплата', ['/payment']); ?></li>
            </ul>
        </div>
        <div class="col-lg-3 no-padding-no-margin text-right">
            <div class="social-links">
                <a href="#" class="fb">&nbsp;</a>
                <a href="#" class="vk">&nbsp;</a>
                <a href="#" class="od">&nbsp;</a>
                <a href="#" class="tw">&nbsp;</a>
                <a href="#" class="yt">&nbsp;</a>
            </div>
            <div class="text-right feedback">
                <span>Помогите нам стать лучше!</span><br/>
                <a href="#">Оставьте свой отзыв</a>
            </div>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
