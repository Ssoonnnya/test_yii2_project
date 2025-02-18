<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<h1>Create Tag</h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name')->textInput() ?>

<?= $form->field($model, 'slug')->textInput() ?>

<div class="form-group">
    <?= Html::submitButton('Create Tag', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
