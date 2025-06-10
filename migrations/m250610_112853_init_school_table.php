<?php

use yii\db\Migration;

class m250610_112853_init_school_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%school}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'region' => $this->integer()->notNull(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%school}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250610_112853_init_school_table cannot be reverted.\n";

        return false;
    }
    */
}
