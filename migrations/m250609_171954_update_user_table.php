<?php

use yii\db\Migration;

class m250609_171954_update_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'email' => $this->string(64)->notNull(),
            'password' => $this->string()->notNull(),
            'firstname' => $this->string(64)->notNull(),
            'surname' => $this->string(64)->notNull(),
            'patronymic' => $this->string(64),
            'phone_number' => $this->string(64)->notNull(),
            'birthdate' => $this->date()->notNull(),
            'gender' => $this->integer()->notNull(),
            'role' => $this->integer()->notNull(),
            'active' => $this->integer()->notNull(),
        ]);

        // Добавляем уникальный индекс для email
        $this->createIndex(
            'idx-user-email',
            'user',
            'email',
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250609_171954_update_user_table cannot be reverted.\n";

        return false;
    }
    */
}
