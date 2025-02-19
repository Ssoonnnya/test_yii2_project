<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\Tag;

/** @var yii\web\View $this */
/** @var app\models\Product $model */
/** @var app\models\Product[] $products */

$this->title = 'Create Product';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="product-create">

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Product Name') ?>
<?= $form->field($model, 'price')->textInput(['type' => 'number', 'step' => '0.01'])->label('Price') ?>
<?= $form->field($model, 'quantity')->textInput(['type' => 'number'])->label('Quantity') ?>

<?= $form->field($model, 'tag_id')->checkboxList(
    Tag::find()->select(['name', 'id'])->indexBy('id')->column()
)->label('Tags') ?>

<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
</div>
