<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_tag}}`.
 */
class m250217_151305_create_product_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('product_tag', [
            'product_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
            'PRIMARY KEY(product_id, tag_id)',
        ]);

        $this->addForeignKey('fk-product_tag-product', 'product_tag', 'product_id', 'product', 'id', 'CASCADE');
        $this->addForeignKey('fk-product_tag-tag', 'product_tag', 'tag_id', 'tag', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_tag}}');
    }
}
