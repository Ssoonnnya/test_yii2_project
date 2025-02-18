<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Tag[] $tags */

$this->title = 'Tags';
?>

<h1><?= Html::encode($this->title) ?></h1>

<!-- Button to create a new tag -->
<p>
    <?= Html::a('Create Tag', ['create'], ['class' => 'btn btn-success']) ?>
</p>

<!-- Check if there are categories -->
<?php if (!empty($tags)): ?>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($tags as $tag): ?>
            <tr>
                <td><?= Html::encode($tag->id) ?></td>
                <td><?= Html::encode($tag->name) ?></td>
                <td>
                    <?= Html::a('View', ['view', 'id' => $tag->id], ['class' => 'btn btn-primary btn-sm']) ?>
                    <?= Html::a('Edit', ['update', 'id' => $tag->id], ['class' => 'btn btn-warning btn-sm']) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $tag->id], [
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
    <p>No tags found.</p>
<?php endif; ?>
