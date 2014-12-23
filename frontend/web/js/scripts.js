$(document).ready(function () {
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // COMMON
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    $("nav.narrow").hide(); 	//Прячем мобильное меню
    $(".cart-section").hide(); 	//Прячем корзину
    $(".categories").hide(); 	//Прячем подменю категорий

    //Открытие/закрытие блока корзины
    $(".cart").click(function () {
        getUserCartContent();
        $(".cart-section").slideToggle(1000);
    });

    //Клик на пункт меню категорий
    $("nav.menu .item").on('click', function () {

        //Определяем координаты центра текущего меню и принадлежащий ему список подменю
        var curcent = $(this).offset().left + $(this).width() / 2 - 6;
        var curitems = $(this).find("ul").html();


        //Если пункт не активен, то...
        if (!$(this).hasClass('active')) {
            //Переключаем класс Active
            $(this).siblings().removeClass('active');
            $(this).addClass('active');

            if (!curitems) {

                //После закрытия очищаем NAV
                //Закрываем блок подменю
                $(".categories").slideUp(function () {
                    //После закрытия очищаем NAV
                    $("#cat-menu ul").html("");
                });
                //Прячем курсор за экран
                $("#main-cur").animate({'left': -20}, 500);

            } else {
                //Если подменю открыто, то...
                if ($("#cat-menu").height() != 0) {
                    //Затухание подменю
                    $("#cat-menu ul").fadeOut(function () {
                        //Заполняем подпункт из списка выбранного пункта и появление
                        $(this).html(curitems).fadeIn();
                        //Сдвиг курсора к текущему пункту
                        $("#main-cur").animate({'left': curcent}, 500);
                    });
                }
                //Если подменю закрыто, то...
                else {
                    //Заполняем подменю
                    $("#cat-menu ul").html(curitems, function () {
                    });
                    //Открываем блок подменю
                    $(".categories").slideDown();
                    //Сдвиг курсора к текущему пункту
                    $("#main-cur").animate({'left': curcent}, 500);
                }
            }

        }
        //Если пункт активен, то...
        else {
            //Закрываем блок подменю
            $(".categories").slideUp(function () {
                //После закрытия очищаем NAV
                $("#cat-menu ul").html("");
            });
            //Прячем курсор за экран
            $("#main-cur").animate({'left': -20}, 500);
            //Удаляем класс active
            $(this).removeClass('active');
        }

    });

    //Закрываем подменю при нажатии на X
    $(".close").on('click', function () {
        $(".categories").slideUp();
    });

    //Управление меню в мобильном режиме

    //Прячем меню при изменении ширины экрана
    $(window).width() < 1100 ? $("nav.narrow").hide() : $("nav.narrow").hide();

    //При клике на кнопку меню
    $(".nar_menu_button").on('click', function () {
        $(this).toggleClass('active'); //Меняем кнопку на активную
        $("nav.narrow").slideToggle(); //Показываем меню
    });

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // PUT PRODUCT TO FAVORITE
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $('.buttons .fav').on('click', function(){
        var _prod = $(this).attr('var-prod');
        $.ajax({
            type:'get',
            url: '/add-to-favorite.html?id='+_prod,
            success: function (msg) {

            }

        })
    });
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // MAIN PAGE
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    //Слайдшоу на главной, инициализация плагина
    $("#slideshow").cycle({
        slides: '.slide',
        next: '#next',
        prev: '#prev'
    });


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // News PAGE
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if ( $('#news-list').length ) {

        var container = $('#news-list');
        // initialize
        container.masonry({
            itemSelector: '.n_block',
            singleMode: true,
            isResizable: true
        });

    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // ITEM PAGE
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    //Предпросмотр фотографий на странице товара

    //При клике на картинку-превью
    $("#item-prev").find('img').on('click', function () {

        //Переключаем класс active
        $(this).siblings().removeClass('active');
        $(this).addClass('active');

        //Поучаем URL изображения
        var curattr = $(this).attr("src");

        //Прячем изображение в блоке большой фотографии
        $(".big-img img").fadeOut(200, function () {
            //Заменяем на выбранное фото и отображаем
            $(this).attr("src", curattr).fadeIn(200);
        });
    });

    //Вертикальная карусель в превью, инициализация плагина
    if ($("#item-prev img").length > 0) {
        $("#item-prev").rcarousel({
            visible: 5,
            step: 3,
            orientation: 'vertical',
            margin: 10,
            width: 80,
            height: 80,
            navigation: {
                next: "#item-prev-up",
                prev: "#item-prev-down"
            }
        });
    } else {
        $("#item-prev img").hide();
        $("#item-prev-up").hide().next().hode();
    }


    //Адаптивная карусель на странице товара

    //Получаем количество элементов, исходя из ширины экрана и устанавливаем размер
    var watchedCount = Math.round($(window).width() / 250);
    var watchedItemSize = Math.round($(".watched-carousel").width() / watchedCount);

    //Инициализация плагина
    $(".watched-carousel").rcarousel({
        visible: watchedCount,
        step: watchedCount,
        width: watchedItemSize,
        height: watchedItemSize,
        orientation: 'horizontal',
        margin: 0,
        navigation: {
            next: "#watched-car-next",
            prev: "#watched-car-prev"
        }
    });

    var icField = $("#item-count"),
        icSub = $(".price .sub"),
        icAdd = $(".price .add"),
        icOne = $(".one-item"),
        icSum = $(".calc-price");

    init_counter(icField, icSub, icAdd, icOne, icSum, 1, 99, 1);

   /* var cartField = $(".cart_counter");

    cartField.each(function () {
        cartSub = $(this).siblings(".cart-sub"),
            cartAdd = $(this).siblings(".cart-add"),
            cartOne = $(this).parent().parent().find(".cart-one-item"),
            cartSum = $(this).parent().parent().find(".cart-calc-price");
        cartItemCount = $(this).val();

        init_counter($(this), cartSub, cartAdd, cartOne, cartSum, 1, 99, 1);
    });*/


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // CATEGORY PAGE
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    //Слайдер цены на старнице категории

    //Переменные для установления максимальной\минимальной цены
    var pr_min = 0,
        pr_max = 0;

    //Инициализация плагина
    $('.range-slider').nstSlider({
        "left_grip_selector": ".lg",
        "right_grip_selector": ".rg",
        "value_bar_selector": ".bar",
        //При изменении положения слайдера
        "value_changed_callback": function (cause, leftValue, rightValue) {
            $(".range-price-min").val(leftValue);  //Меняем значение поля минимальной  цены
            $(".range-price-max").val(rightValue); //Меняем значение поля максимальной цены
        }
    });

    //Изменение поля ввода
    $(".range").on('input', function () {
        //Проверка введенного значения
        if (typeof($(this).val()) != NaN && $(this).val() > 0) {
            pr_min = $(".range-price-min").val();
            pr_max = $(".range-price-max").val();
        }
        else {
            pr_min = 25000;
            pr_max = 175000;
        }

        //Установка слайдера в указанную позицию
        $('.range-slider').nstSlider('set_position', pr_min, pr_max);
    });


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

});

/*
 Счетчик
 ///////////
 field    - INOUT с цифрой количества
 sub      - элемент для уменьшения количества
 add 	 - элемент для увеличения количества
 onePrice - SPAN с величиной суммы за 1 предмет
 sumPrice - SPAN для вывода суммы за указанное количество предметов
 min      - минимальное количество
 max      - максимальное количество
 def      - количество по умолчанию при загрузке страницы
 */
function init_counter(field, sub, add, onePrice, sumPrice, min, max, def) {

    def < min ? def = min : "";

    //Количество по умолчанию
    var itemCount = def;


    //Цена за один товар
    var one = onePrice.text();

    if (field.val() == "") {
        field.val(itemCount)
    } else {
        itemCount = field.val();
    }

    sumPrice.text(one * itemCount);

    //Прибавить
    add.on('click', function () {

        //Если количество не больше максимального
        if (itemCount < max) {
            itemCount++; 					//плюс 1
            sumPrice.text(one * itemCount); //Подсчет суммы
            field.val(itemCount);        	//Изменение значения в поле
        }
    });

    //Убавить
    sub.on('click', function () {

        //Если количество не меньше минимального
        if (itemCount > min) {
            itemCount--;					//Минус 1
            sumPrice.text(one * itemCount); //Подсчет суммы
            field.val(itemCount);			//Изменение значения в поле
        }
    });

    //ИЗменить в поле ввода
    field.on('input', function () {

        //Запись введенного значения в переменную
        itemCount = $(this).val();

        //Если введенная строка - число в диапазоне [min;max], то...
        if (itemCount > min && itemCount < max && typeof(itemCount) != NaN) {
            //Подсчитываем сумму
            sumPrice.text(one * itemCount);
        }
        //Иначе, если введенная строка - число больше максимального, то...
        else if (itemCount > max && typeof(itemCount) != NaN) {
            $(this).val(max)				//Меняем значение поля на максимально
            itemCount = $(this).val();		//Присваиваем переменной значение поля
            sumPrice.text(one * itemCount); //Подсчитываем сумму
        }
        else {
            $(this).val(min);				//Меняем значение поля на минимальное
            itemCount = $(this).val();		//Присваиваем переменной значение поля
            sumPrice.text(one * itemCount); //Подсчитываем сумму
        }
    });
}

function getUserCartContent() {

    $.ajax({
        type:'get',
        url: '/get-cart-content.html',
        success: function (msg) {
            $('.cart-section').html("");
            $('.cart-section').html(msg);
        }
    });

}
