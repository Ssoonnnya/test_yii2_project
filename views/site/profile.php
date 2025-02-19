<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<h1>Welcome <?= Html::encode($username) ?></h1>

<p>
    <?= Html::a('Logout', Url::to(['site/logout']), [
        'class' => 'btn btn-danger',
        'data-method' => 'post'
    ]) ?>
</p>
