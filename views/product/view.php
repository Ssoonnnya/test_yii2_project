<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Product $model */

$this->title = 'Product: ' . $model->name;
?>

<h1><?= Html::encode($this->title) ?></h1>

<p><strong>Name:</strong> <?= Html::encode($model->name) ?></p>
<p><strong>Price:</strong> <?= Html::encode($model->price) ?></p>
<p><strong>Quantity:</strong> <?= Html::encode($model->quantity) ?></p>



<p>
    <?= Html::a('Back to Products', ['index'], ['class' => 'btn btn-primary']) ?>
</p>
