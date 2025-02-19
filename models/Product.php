<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property int $quantity
 *
 * @property Category[] $categories
 * @property ProductCategory[] $productCategories
 * @property ProductTag[] $productTags
 * @property Tag[] $tags
 */
class Product extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public $tag_id;
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'quantity'], 'required'],
            [['price'], 'number'],
            [['quantity'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['tag_id'], 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'quantity' => 'Quantity',
        ];
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])->viaTable('product_category', ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductCategories()
    {
        return $this->hasMany(ProductCategory::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductTags()
    {
        return $this->hasMany(ProductTag::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Tags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->viaTable('product_tag', ['product_id' => 'id'], ['tag_id' => 'id']);
    }

    public function setTags($tagIds)
    {
        Yii::$app->db->createCommand()->delete('product_tag', ['product_id' => $this->id])->execute();

        if (!empty($tagIds)) {
            foreach ($tagIds as $tagId) {
                if (is_numeric($tagId)) {
                    $result = Yii::$app->db->createCommand()->insert('product_tag', [
                        'product_id' => $this->id,
                        'tag_id' => $tagId,
                    ])->execute();

                    if ($result === false) {
                        Yii::debug("Failed to insert tag ID: $tagId for product ID: {$this->id}");
                    } else {
                        Yii::debug("Successfully inserted tag ID: $tagId for product ID: {$this->id}");
                    }
                }
            }
        } else {
            Yii::debug("No tag IDs provided for product ID: {$this->id}");
        }
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->tag_id = Tag::find()
            ->select('tag_id')
            ->from('product_tag')
            ->where(['product_id' => $this->id])
            ->column();
    }

}
