<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Product[] $products */

$this->title = 'Products';
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
</p>

<?php if (!empty($products)): ?>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= Html::encode($product->id) ?></td>
                <td><?= Html::encode($product->name) ?></td>
                <td><?= Html::encode($product->price) ?></td>
                <td><?= Html::encode($product->quantity) ?></td>

                <td>
                    <?= Html::a('View', ['view', 'id' => $product->id], ['class' => 'btn btn-primary btn-sm']) ?>
                    <?= Html::a('Edit', ['update', 'id' => $product->id], ['class' => 'btn btn-warning btn-sm']) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $product->id], [
                        'class' => 'btn btn-danger btn-sm',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this Product?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No products found.</p>
<?php endif; ?>
