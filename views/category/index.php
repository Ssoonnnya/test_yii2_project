<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Category[] $categories */

$this->title = 'Categories';
?>

<h1><?= Html::encode($this->title) ?></h1>

<!-- Button to create a new category -->
<p>
    <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
</p>

<!-- Check if there are categories -->
<?php if (!empty($categories)): ?>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= Html::encode($category->id) ?></td>
                <td><?= Html::encode($category->name) ?></td>
                <td>
                    <?= Html::a('View', ['view', 'id' => $category->id], ['class' => 'btn btn-primary btn-sm']) ?>
                    <?= Html::a('Edit', ['update', 'id' => $category->id], ['class' => 'btn btn-warning btn-sm']) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $category->id], [
                        'class' => 'btn btn-danger btn-sm',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this category?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No categories found.</p>
<?php endif; ?>
