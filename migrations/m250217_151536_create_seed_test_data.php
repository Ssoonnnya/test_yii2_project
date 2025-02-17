<?php

use yii\db\Migration;

class m250217_151536_create_seed_test_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        for ($i = 1; $i <= 10; $i++) {
            $this->insert('category', [
                'id' => $i,
                'name' => "Category $i",
                'lft' => $i * 2,
                'rgt' => $i * 2 + 1,
                'depth' => rand(1, 4),
            ]);
        }

        for ($i = 1; $i <= 20; $i++) {
            $this->insert('tag', [
                'id' => $i,
                'name' => "Tag $i",
            ]);
        }

        for ($i = 1; $i <= 100; $i++) {
            $this->insert('product', [
                'name' => "Product $i",
                'price' => rand(100, 1000),
                'quantity' => rand(1, 100),
            ]);

            $productId = $this->db->getLastInsertID();

            $this->insert('product_category', [
                'product_id' => $productId,
                'category_id' => rand(1, 10),
            ]);

            $this->insert('product_tag', [
                'product_id' => $productId,
                'tag_id' => rand(1, 20),
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('product_category');
        $this->truncateTable('product_tag');
        $this->truncateTable('product');
        $this->truncateTable('category');
        $this->truncateTable('tag');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250217_151536_create_seed_test_data cannot be reverted.\n";

        return false;
    }
    */
}
