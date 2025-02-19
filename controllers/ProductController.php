<?php

namespace app\controllers;

use app\models\Product;
use Yii;
use yii\filters\AccessControl;

class ProductController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $products = Product::find()->all();

        return $this->render('index', [
            'products' => $products,
        ]);
    }

    public function actionCreate()
    {
        $model = new Product();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Product::findOne($id);

        if ($model === null) {
            throw new \yii\web\NotFoundHttpException('The requested Product does not exist.');
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
        $model = Product::findOne($id);

        if ($model !== null) {
            $model->delete();
        }

        return $this->redirect(['index']);
    }

    public function actionView($id) {

        $model = Product::findOne($id);

        if ($model === null) {
            throw new \yii\web\NotFoundHttpException('The requested Product does not exist.');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
