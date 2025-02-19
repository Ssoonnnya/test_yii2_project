<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\Tag;

/** @var yii\web\View $this */
/** @var app\models\Product $model */
/** @var app\models\Product[] $products */

$this->title = 'Update Product: ' . Html::encode($model->name);
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="product-update">

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Product Name') ?>
<?= $form->field($model, 'price')->textInput(['type' => 'number', 'step' => '0.01'])->label('Price') ?>
<?= $form->field($model, 'quantity')->textInput(['type' => 'number'])->label('Quantity') ?>

<?= $form->field($model, 'tag_id')->checkboxList(
    Tag::find()->select(['name', 'id'])->indexBy('id')->column()
)->label('Tags') ?>

<div class="form-group">
    <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
</div>
