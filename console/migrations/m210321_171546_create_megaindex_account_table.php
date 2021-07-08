<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%megaindex_account}}`.
 */
class m210321_171546_create_megaindex_account_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%megaindex_account}}', [
            'id' => $this->primaryKey(),
            'login' => $this->string(255),
            'password' => $this->string(255),
            'proxy_id' => $this->integer(),
            'useragent_id' => $this->integer(),
        ], $tableOptions);

        $this->createIndex(
            'idx-megaindex_account-login',
            'megaindex_account',
            'login',
            true
        );

        $this->createIndex(
            'idx-megaindex_account-proxy_id',
            'megaindex_account',
            'proxy_id'
        );

        $this->createIndex(
            'idx-megaindex_account-useragent_id',
            'megaindex_account',
            'useragent_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%megaindex_account}}');
    }
}
