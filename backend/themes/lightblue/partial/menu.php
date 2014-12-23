<?php
use yii\helpers\Url;

//$route = Yii::$app->controller->getRoute();
$route = Yii::$app->controller->getUniqueId();
?>
<nav id="sidebar" class="sidebar nav-collapse collapse">
    <ul id="side-nav" class="side-nav">
        <li class="<?= ($route == 'admin/default') ? "active": "panel"; ?>">
            <a href="<?= Url::toRoute('/admin/default/index'); ?>"><i class="fa fa-home"></i> <span class="name">Приборная панель</span></a>
        </li>
        <li class="<?= ($route == 'menu/group') ? "active" : "panel"; ?>">
            <a href="<?= Url::toRoute('/menu/group/index'); ?>"><i class="fa fa-bars"></i> <span
                    class="name">Меню</span></a>
        </li>
<!--        <li class="panel">-->
<!--            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#side-nav" href="#">-->
<!--                <i class="fa fa-edit"></i> <span class="name">Управление<br/>меню </span>-->
<!--            </a>-->
<!--                        <ul id="forms-collapse" class="panel-collapse collapse">-->
<!--                            <li><a href="form_account.html">Account</a></li>-->
<!--                            <li><a href="form_article.html">Article</a></li>-->
<!--                            <li><a href="form_elements.html">Elements</a></li>-->
<!--                            <li><a href="form_validation.html">Validation</a></li>-->
<!--                            <li><a href="form_wizard.html">Wizard</a></li>-->
<!--                        </ul>-->
<!--        </li>-->
        <li class="<?= ($route == 'pages/default') ? "active": "panel"; ?>">
            <a class="accordion-toggle collapsed"
               href="<?= Url::toRoute('/pages/default/index') ?>"><i class="fa fa-edit"></i> <span
                    class="name">Страницы</span></a>
<!--            <ul id="stats-collapse" class="panel-collapse collapse">-->
<!--                <li><a href="stat_statistics.html">Stats</a></li>-->
<!--                <li><a href="stat_charts.html">Charts</a></li>-->
<!--                <li><a href="stat_realtime.html">Realtime</a></li>-->
<!--            </ul>-->
        </li>
        <li class="<?= ($route == 'post/default') ? "active" : "panel"; ?>">
            <a href="<?= Url::toRoute('/post/default/index'); ?>"><i class="fa fa-edit"></i> <span
                    class="name">Посты</span></a>
        </li>

        <li class="<?= ($route == 'catalog/default' ||
            $route == 'catalog/manufacture' ||
            $route == 'catalog/promotion' ||
            $route == 'catalog/category' ||
            $route == 'catalog/uploadCvs' ||
            $route == 'catalog/genXml') ? "active": "panel"; ?>">
            <a class="accordion-toggle collapsed" data-toggle="collapse"
               data-parent="#side-nav" href="#components-collapse"><i class="fa fa-shopping-cart"></i> <span
                    class="name">Управление товаром</span></a>
            <ul id="components-collapse" class="panel-collapse collapse">
                <li><a href="<?= Url::toRoute('/catalog/default/index') ?>">Каталог</a></li>
                <li><a href="<?= Url::toRoute('/catalog/promotion/index') ?>" >Продвигаемая продукция</a></li>
                <li><a href="<?= Url::toRoute('/catalog/slider/index') ?>" >Слайдер</a></li>
                <li><a href="<?= Url::toRoute('/catalog/manufacture/index') ?>">Производитель</a></li>
                <li><a href="<?= Url::toRoute('/catalog/category/index') ?>">Категория</a></li>
                <li><a href="<?= Url::toRoute('/catalog/upload-xls/index') ?>">Импорт XLS</a></li>
                <li><a href="<?= Url::toRoute('/catalog/genXml/index') ?>">Экспорт XML</a></li>
            </ul>
        </li>
<!--        <li class="--><?//= ($route == 'export/yandex') ? "active": "panel"; ?><!--">-->
<!--            <a class="accordion-toggle collapsed" data-toggle="collapse"-->
<!--               data-parent="#side-nav" href="#export-collapse"><i class="fa fa-share-square"></i> <span-->
<!--                    class="name">Экспорт данных</span></a>-->
<!--            <ul id="export-collapse" class="panel-collapse collapse">-->
<!--                <li><a href="--><?//= Url::toRoute('/export/yandex/market-yml') ?><!--" >Yandex Market</a></li>-->
<!---->
<!--            </ul>-->
<!--        </li>-->
        <li class="<?=
            (
            $route == 'catalog/product-type' ||
            $route == 'catalog/product-property-group' ||
            $route == 'catalog/product-property'
            ) ? "active": "panel"; ?>">
            <a class="accordion-toggle collapsed" data-toggle="collapse"
               data-parent="#side-nav" href="#properties-collapse"><i class="fa fa-bars"></i> <span
                    class="name">Управление свойствами товара</span></a>
            <ul id="properties-collapse" class="panel-collapse collapse">
                <li><a href="<?= Url::toRoute('/catalog/product-type/index') ?>">Тип продукта</a></li>
                <li><a href="<?= Url::toRoute('/catalog/product-property-group/index') ?>">Группа свойство продуктов</a></li>
                <li><a href="<?= Url::toRoute('/catalog/product-property/index') ?>">Свойство продукта</a></li>
            </ul>
        </li>
        <li class="<?= ($route == 'catalog/comment') ? "active": "panel"; ?>">
            <a class="accordion-toggle collapsed" href="<?= Url::toRoute('/catalog/comment/index') ?>"><i class="fa fa-comments-o"></i> <span class="name">Отзывы (<?=\common\modules\catalog\models\ProductComment::find()->where('approve = 0')->count()?>)</span></a>
<!--            <ul id="tables-collapse" class="panel-collapse collapse">-->
<!--                <li><a href="tables_static.html">Static</a></li>-->
<!--                <li><a href="tables_dynamic.html">Dynamic</a></li>-->
<!--            </ul>-->
        </li>
        <li class="<?= ($route == 'order/default' ||
                        $route == 'order/status') ? "active": "panel"; ?>">
            <a class="accordion-toggle collapsed"
               data-toggle="collapse"
               data-parent="#side-nav"
               href="#order-manager-collapse"><i class="fa fa-shopping-cart"></i> <span class="name">Управление Заказами</span></a>
            <ul id="order-manager-collapse" class="panel-collapse collapse">
                <li><a href="<?= Url::toRoute('/order/default/index') ?>">Заказы</a></li>
                <li><a href="<?= Url::toRoute('/order/status/index') ?>">Статус заказа</a></li>
            </ul>
        </li>
        <li class="<?= ($route == 'user/default' ||
                        $route == 'mailing/default' ||
                        $route == 'user/role') ? "active": "panel"; ?>">
            <a class="accordion-toggle collapsed" data-toggle="collapse"
               data-parent="#side-nav" href="#special-collapse"><i class="fa fa-users"></i> <span
                    class="name">Управление пользователями</span></a>
            <ul id="special-collapse" class="panel-collapse collapse">
                <li><a href="<?= Url::toRoute('/user/default/index') ?>"><i class="fa fa-user"></i> <span class="name" >Пользователи</span></a></li>
                <li><a href="<?= Url::toRoute('/user/role/index') ?>"><i class="fa fa-user"></i> <span class="name" >Роль</span></a></li>
                <li><a href="<?= Url::toRoute('/mailing/default/index') ?>"><i class="fa fa-comment"></i> <span class="name" >Управление рассылкой</span></a></li>

<!--                <li><a href="special_invoice.html">Invoice</a></li>-->
<!--                <li><a href="special_inbox.html">Inbox <span class="label label-important">3</span></a></li>-->
<!--                <li><a href="login.html">Login</a></li>-->
<!--                <li><a href="special_404.html">404</a></li>-->
<!--                <li><a href="landing.html" data-no-pjax>Landing</a></li>-->
<!--                <li><a href="white/index.html" data-no-pjax>White <i class="fa fa-external-link-square"></i></a></li>-->
            </ul>
        </li>
<!--        <li class="panel">-->
<!--            <a class="accordion-toggle collapsed" data-toggle="collapse"-->
<!--               data-parent="#side-nav" href="index.html#menu-levels-collapse"><i class="fa fa-code-fork"></i> <span-->
<!--                    class="name">Menu Levels</span></a>-->
<!--            <ul id="menu-levels-collapse" class="panel-collapse collapse">-->
<!--                <li><a href="index.html#">Item 1.1</a></li>-->
<!--                <li><a href="index.html#">Item 1.2</a></li>-->
<!--                <li class="panel">-->
<!--                    <a class="accordion-toggle collapsed" data-toggle="collapse"-->
<!--                       data-parent="#menu-levels-collapse" href="index.html#sub-menu-1-collapse">Item 1.3</a>-->
<!--                    <ul id="sub-menu-1-collapse" class="panel-collapse collapse">-->
<!--                        <li class="panel">-->
<!--                            <a class="accordion-toggle collapsed" data-toggle="collapse"-->
<!--                               data-parent="#sub-menu-1-collapse" href="index.html#sub-menu-3-collapse">Item 2.1</a>-->
<!--                            <ul id="sub-menu-3-collapse" class="panel-collapse collapse">-->
<!--                                <li><a href="index.html#">Item 3.1</a></li>-->
<!--                                <li><a href="index.html#">Item 3.2</a></li>-->
<!--                                <li><a href="index.html#">Item 3.3</a></li>-->
<!--                            </ul>-->
<!--                        </li>-->
<!--                        <li><a href="index.html#">Item 2.2</a></li>-->
<!--                        <li class="panel">-->
<!--                            <a class="accordion-toggle collapsed" data-toggle="collapse"-->
<!--                               data-parent="#sub-menu-1-collapse" href="index.html#sub-menu-2-collapse">Item 2.3</a>-->
<!--                            <ul id="sub-menu-2-collapse" class="panel-collapse collapse">-->
<!--                                <li><a href="index.html#">Item 3.4</a></li>-->
<!--                                <li><a href="index.html#">Item 3.5</a></li>-->
<!--                                <li><a href="index.html#">Item 3.6</a></li>-->
<!--                            </ul>-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                </li>-->
<!--            </ul>-->
<!--        </li>-->
        <li class="visible-xs">
            <a href="<?= Url::toRoute('/admin/default/logout') ?>"><i class="fa fa-sign-out"></i> <span class="name">Выход</span></a>
        </li>
    </ul>
    <div id="sidebar-settings" class="settings">
        <button type="button"
                data-value="icons"
                class="btn-icons btn btn-transparent btn-sm">Иконки
        </button>
        <button type="button"
                data-value="auto"
                class="btn-auto btn btn-transparent btn-sm">Авто
        </button>
    </div>
</nav>
