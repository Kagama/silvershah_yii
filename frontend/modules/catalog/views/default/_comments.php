<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 01.09.14
 * Time: 16:20
 */
use yii\helpers\Html;
use yii\web\View;

Yii::$app->view->registerJs("
    $(\".comment-form .submit-form\").on(\"click\", function(){
        $.ajax({
            type:\"post\",
            data: $(\".comment-form\").serialize(),
            url: $(\".comment-form\").attr(\"action\"),
            dataType:\"json\",
            success : function (json) {
                if (json.error) {
                    if (json.content != '') {
                        $('.comment-form-block').empty();
                        $('.comment-form-block').html(json.content);
                    }

                } else {
                    if (json.success != '') {
                        $('.comment-form')[0].reset();
                        $('.alert-success').empty();
                        $('.alert-success').html(json.success).slideDown(400).delay(2500).slideUp(400);
                    } else {
                        alert(json.message);
                    }
                }
            },
            error : function (jqXHR, textStatus, errorThrown) {
            }
        });
        return false;
    });

    $('.add-comment-btn').on('click', function(){
        $('.comment-form-block').slideToggle('slow');
        if ($(this).hasClass('active')) {
            $('.add-comment-btn').removeClass('active');
        } else {
            $('.add-comment-btn').addClass('active');
        }
        return false;
   });

", View::POS_READY);
?>
<div class="comment-list">


    <div class="text-right" style="padding-bottom: 10px;">
        <?= Html::a('Добавить отзыв', '#', ['class' => 'add-comment-btn']) ?>
    </div>
    <div class="alert-success" style="display: none;">

    </div>
    <div class="comment-form-block" style="display: none;">
        <?= $this->render('../comment/add', ['product' => $model, 'model' => new \common\modules\catalog\models\ProductComment()]) ?>
    </div>
    <h3>Отзывы</h3>
    <?php
    if ($model->comments != null) {
        $count = count($model->comments);
        foreach ($model->comments as $index => $comment) {
            ?>
            <div class="user-comment" <?=($count == ($index+1) ? "style='border:none;'" : "")?>>
                <div class="row">
                    <div class="col-lg-2">
                        <div>
                            <?=
                            \kartik\widgets\StarRating::widget([
                                'name' => 'rate_' . $index,
                                'value' => $comment->rate,
                                'pluginOptions' => [
                                    'glyphicon' => false,
                                    'step' => 1,
                                    'size' => 'xs',
                                    'disabled' => true,
                                    'showCaption' => false,
                                    'showClear' => false,
                                    'symbol' => mb_convert_encoding("&#9632;", 'UTF-8', 'HTML-ENTITIES')
                                ]]);?>
                        </div>
                        <div class="username"><?= $comment->username ?></div>

                        <div class="date"><?=$comment->date ?></div>
                    </div>
                    <div class="col-lg-10 review">
                        <?= $comment->text ?>
                    </div>
                </div>
            </div>
        <?php
        }
    } else {
        ?>
        <p style="padding-top: 20px; font-size: 14px; ">-- Нет отзывов --</p>
    <?php
    }
    ?>
</div>