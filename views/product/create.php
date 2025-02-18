<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Product $model */
/** @var app\models\Product[] $products */

$this->title = 'Create Product';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'price')->textInput(['type' => 'number', 'maxlength' => true]) ?>

<?= $form->field($model, 'quantity')->textInput(['type' => 'number', 'min' => 0]) ?>

<div class="form-group">
    <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
