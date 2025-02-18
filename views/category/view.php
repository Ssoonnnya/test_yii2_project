<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Category $model */

$this->title = 'Category: ' . $model->name;
?>

<h1><?= Html::encode($this->title) ?></h1>

<p><strong>Name:</strong> <?= Html::encode($model->name) ?></p>
<p><strong>Left Value:</strong> <?= Html::encode($model->lft) ?></p>
<p><strong>Right Value:</strong> <?= Html::encode($model->rgt) ?></p>
<p><strong>Depth:</strong> <?= Html::encode($model->depth) ?></p>

<p>
    <?= Html::a('Back to Categories', ['index'], ['class' => 'btn btn-primary']) ?>
</p>
