<?php

namespace app\controllers;

use app\models\Category;
use Yii;

class CategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $categories = Category::find()->all();

        return $this->render('index', [
            'categories' => $categories,
        ]);
    }

    public function actionCreate()
    {
        $model = new Category();

        $categories = Category::find()->all();

        if ($model->load(Yii::$app->request->post())) {

            // If Request have no parent_id, than it would be root category
            if ($model->parent_id === null) {

                $maxRight = Category::find()->max('rgt');
                $model->lft = $maxRight + 1;
                $model->rgt = $maxRight + 2;
                $model->depth = 0;
            } else {

                // If request have parent_id
                $parent = Category::findOne($model->parent_id);
                if ($parent) {

                    $model->lft = $parent->rgt;
                    $model->rgt = $parent->rgt + 1;
                    $model->depth = $parent->depth + 1;

                    Category::updateAllCounters(['rgt' => 2], ['>', 'rgt', $parent->rgt]);
                    Category::updateAllCounters(['lft' => 2], ['>', 'lft', $parent->rgt]);
                }
            }

            if ($model->save()) {
                Yii::info("Category saved with lft: {$model->lft}, rgt: {$model->rgt}, depth: {$model->depth}");
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'categories' => $categories,
        ]);
    }


    public function actionUpdate($id)
    {
        $model = Category::findOne($id);

        if ($model === null) {
            throw new \yii\web\NotFoundHttpException('The requested category does not exist.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = Category::findOne($id);

        if ($model !== null) {
            $model->delete();
        }

        return $this->redirect(['index']);
    }

    public function actionView($id) {

        $model = Category::findOne($id);

        if ($model === null) {
            throw new \yii\web\NotFoundHttpException('The requested category does not exist.');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

}
