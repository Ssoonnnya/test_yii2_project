<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Tag $model */

$this->title = 'Tag: ' . $model->name;
?>

<h1><?= Html::encode($this->title) ?></h1>

<p><strong>Name:</strong> <?= Html::encode($model->name) ?></p>

<p>
    <?= Html::a('Back to Tags', ['index'], ['class' => 'btn btn-primary']) ?>
</p>
