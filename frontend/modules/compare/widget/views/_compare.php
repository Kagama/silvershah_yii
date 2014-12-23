<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 02.09.14
 * Time: 14:54
 */
use yii\helpers\Html;
use yii\web\View;

Yii::$app->view->registerJs('

    $(document).on("click", ".add-to-compare", function(){
        var _url = $(this).attr("href");
        var _noindex = $(this).parent("noindex");
        $.ajax({
            type:"GET",
            url:_url,
            dataType:"json",
            success : function (json) {
                if (json.error != "") {
                    alert(json.error);
                } else {
                    $(_noindex).replaceWith(json._html);
                }
            },
            error: function(jqXHR, textStatus, string) {
                alert(textStatus+" "+string);
            }
        });
        return false;
    });
//    $(".add-to-compare").on("click", function() {
//        var _url = $(this).attr("href");
//        var _noindex = $(this).parent("noindex");
//        $.ajax({
//            type:"post",
//            url:_url,
//            dataType:"json",
//            success : function (json) {
//                if (json.error != "") {
//                    alert(json.error);
//                } else {
//                    $(_noindex).replaceWith(json._html);
//                }
//            }
//        });
//        return false;
//    });
', View::POS_READY);

?>
<?php
$_temp = \Yii::$app->session->get('compare', []);


if (!empty($_temp)) {
    $compare = unserialize($_temp);
} else {
    $compare = $_temp;
}
$checkProdInCompare = false;
$prodCount = 0;
for($i = 0; $i < count($compare); $i++ ) {
    if ($product->id == $compare[$i]) {
        $checkProdInCompare = true;
    }

    $prod = \common\modules\catalog\models\Product::findOne($compare[$i]);
    if ($product->category_id == $prod->category_id) {
        $prodCount = $prodCount + 1;
    }
}
if (empty($compare) || !$checkProdInCompare) {
    ?>
    <noindex><?= Html::a('Добавить к сравнению', ["/add-to-compare", 'id' => $product->id], ['class' => 'add-to-compare', 'rel' => 'nofollow', 'data-pjax' => '0']) ?></noindex>
<?
}
if ($checkProdInCompare) {
    ?>
    <noindex><?=Html::a('Сравнить ('.$prodCount.')', ['/show-compare-products'], ['rel' => 'nofollow', 'class' => 'show-compare'] )?></noindex>
<?php
}
?>
