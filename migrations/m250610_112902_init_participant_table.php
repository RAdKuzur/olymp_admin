<?php

use yii\db\Migration;

class m250610_112902_init_participant_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%participant}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'disability' => $this->integer()->notNull(),
            'citizenship' => $this->integer()->notNull(),
            'class' => $this->integer()->notNull(),
            'school_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            '{{%idx-participant-user_id}}',
            '{{%participant}}',
            'user_id'
        );

        $this->createIndex(
            '{{%idx-participant-school_id}}',
            '{{%participant}}',
            'school_id'
        );

        $this->addForeignKey(
            '{{%fk-participant-user_id}}',
            '{{%participant}}',
            'user_id',
            '{{%user}}',
            'id',
            'RESTRICT'
        );

        $this->addForeignKey(
            '{{%fk-participant-school_id}}',
            '{{%participant}}',
            'school_id',
            '{{%school}}',
            'id',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-participant-school_id}}',
            '{{%participant}}'
        );
        $this->dropForeignKey(
            '{{%fk-participant-user_id}}',
            '{{%participant}}'
        );
        $this->dropTable('{{%participant}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250610_112902_init_participant_table cannot be reverted.\n";

        return false;
    }
    */
}
