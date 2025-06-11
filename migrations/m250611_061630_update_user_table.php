<?php

use yii\db\Migration;

class m250611_061630_update_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropIndex(
            'idx-user-email',
            'user'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createIndex(
            'idx-user-email',
            'user',
            'email',
            true
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250611_061630_update_user_table cannot be reverted.\n";

        return false;
    }
    */
}
