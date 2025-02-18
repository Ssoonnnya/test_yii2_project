<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Tag $model */
/** @var app\models\Tag[] $categories */
?>

<h1>Create Tag</h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name')->textInput() ?>

<div class="form-group">
    <?= Html::submitButton('Create Tag', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
