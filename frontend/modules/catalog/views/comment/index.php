<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 01.09.14
 * Time: 15:19
 */
use \yii\helpers\Html;
use yii\web\View;

Yii::$app->view->registerJs("

   $('.add-comment-btn').on('click', function(){
        $('.comment-form-block').slideToggle('slow');
        return false;
   });

", View::POS_READY);

?>
<?php $this->beginPage() ?>
<?php $this->head() ?>
<?php $this->beginBody() ?>
<div class="comment-list">


    <div class="text-right">
        <?= Html::a('Добавить отзыв', '#', ['class' => 'add-comment-btn']) ?>
    </div>
    <div class="comment-form-block" style="display: none;">

    </div>
    <h3>Отзывы</h3>
    <?php
    if ($comments != null) {
        foreach ($comments as $comment) {
            ?>
            <div class="user-comment">
                <div class="row">
                    <div class="col-lg-4">
                        <?= "rate" ?>
                        <span class="username"><?= $comment->username ?></span>
                        <span class="date"><?= date("d.m.Y", $comment->date) ?></span>
                    </div>
                    <div class="col-lg-8">
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
<?php $this->endBody() ?>
<?php $this->endPage() ?>
