/**
 * Created by developer on 26.07.14.
 */
$(document).ready(function(){

    $(document).on("click", ".add-to-cart-button", function() {
        var quantity = $(this).parent('.buttons').prev('div.chars').prev('div.price').children('#item-count').val();
        var quantity_el = $(this).parent('.buttons').prev('div.chars').prev('div.price').children('#item-count');
        var link = $(this);

        //alert($(link).attr('var-href')+"&quantity="+quantity);
        $.ajax({
            type:'GET',
            url:$(link).attr('var-href')+"&quantity="+quantity,
            dataType:'json',
            success : function (result) {
                if (result.error == false) {
                    $('.opt .cart span.count').html(result.total.quantity);
                    //$('#head .head-top .cart a').attr('href', '/cart.html');
                    var icField = $("#item-count"),
                        icSub   = $(".price .sub"),
                        icAdd   = $(".price .add"),
                        icOne   = $(".one-item"),
                        icSum   = $(".calc-price");
                    icField.val(1);
                    init_counter(icField, icSub, icAdd, icOne, icSum, 1, 9, 1);
                    //if ($(quantity_el).length > 0) {
                    //    quantity_el.val("");
                    //    quantity_el.val(1);
                    //}
                } else {
                    alert(result.message);
                }
            }
        });
        return false;
    });

    /**
     * Уменьшаем количество товаров
     */
    $(document).on("click", ".add-to-cart .quantity .minus", function(){
        var quantity = $(this).next('input');
        if (quantity.val() > 1) {
            quantity.val(parseInt(quantity.val()) - 1);
        }
        return false;
    });

    /**
     * Увеличиваем количество товаров
     */
    $(document).on("click", ".add-to-cart .quantity .plus", function(){
        var quantity = $(this).prev('input');
        if (quantity.val() < 99) {
            quantity.val(parseInt(quantity.val()) + 1);
        }
        return false;
    });

});