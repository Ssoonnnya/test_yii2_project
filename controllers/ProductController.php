<?php

namespace app\controllers;

use app\models\Product;
use app\models\ProductTag;
use app\models\Tag;
use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

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

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {

                if (!empty($model->tag_id)) {
                    foreach ($model->tag_id as $tagId) {
                        $productTag = new ProductTag();
                        $productTag->product_id = $model->id;
                        $productTag->tag_id = $tagId;
                        $productTag->save();
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $existingTags = ProductTag::find()->select('tag_id')->where(['product_id' => $model->id])->column();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                ProductTag::deleteAll(['product_id' => $model->id]);

                if (!empty($model->tag_id)) {
                    foreach ($model->tag_id as $tagId) {
                        $productTag = new ProductTag();
                        $productTag->product_id = $model->id;
                        $productTag->tag_id = $tagId;
                        $productTag->save();
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'tags' => Tag::find()->select(['name', 'id'])->indexBy('id')->column(),
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
