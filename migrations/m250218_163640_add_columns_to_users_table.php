<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%users}}`.
 */
class m250218_163640_add_columns_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%users}}', 'username', $this->string()->notNull()->unique());
        $this->addColumn('{{%users}}', 'email', $this->string()->notNull()->unique());
        $this->addColumn('{{%users}}', 'password_hash', $this->string()->notNull());
        $this->addColumn('{{%users}}', 'auth_key', $this->string()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%users}}', 'username');
        $this->dropColumn('{{%users}}', 'email');
        $this->dropColumn('{{%users}}', 'password_hash');
        $this->dropColumn('{{%users}}', 'auth_key');
    }
}
