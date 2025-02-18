<?php

namespace app\controllers;

use app\models\Tag;
use Yii;

class TagController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $tags = Tag::find()->all();

        return $this->render('index', [
            'tags' => $tags,
        ]);
    }
    public function actionCreate()
    {
        $model = new Tag();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', 'Tag created successfully!');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Tag::findOne($id);

        if ($model === null) {
            throw new \yii\web\NotFoundHttpException('The requested Tag does not exist.');
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
        $model = Tag::findOne($id);

        if ($model !== null) {
            $model->delete();
        }

        return $this->redirect(['index']);
    }

    public function actionView($id) {

        $model = Tag::findOne($id);

        if ($model === null) {
            throw new \yii\web\NotFoundHttpException('The requested Tag does not exist.');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
