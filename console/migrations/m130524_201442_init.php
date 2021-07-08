<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->insert('{{%user}}', [
            'username' => 'admin',
            'auth_key' => 'plr3KiE1Q8oX8Dbtm5Lr9MoPazhadGa9',
            'password_hash' => '$2y$13$2szabPRAHiyZQVP7XpFtuOJnFsm0GO4AHh5ALkfbxXR9gIxDh75qO',
            'password_reset_token' => '',
            'email' => 'greatseo@yandex.ru',
            'status' => 10,
            'created_at' => 1598148877,
            'updated_at' => 1598148877,
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
