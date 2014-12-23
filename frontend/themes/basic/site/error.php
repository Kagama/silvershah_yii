<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var string $name
 * @var string $message
 * @var Exception $exception
 */

$this->title = $name;
?>
<div class="row no-padding-no-margin content-block-top-shadow" style="background-color: #f4f4f4;">
    <div class="align-center">
        <div class="site-error">

            <h1><?= Html::encode($this->title) ?></h1>

            <div class="alert alert-danger">
                <?= nl2br(Html::encode($message)) ?>
            </div>



        </div>
    </div>
</div>
