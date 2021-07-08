<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%domain}}`.
 */
class m201009_134926_create_domain_table extends Migration
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

        $this->createTable('{{%domain}}', [
            'id' => $this->primaryKey(),
            'domain' => $this->string(255),
            'category_id' => $this->integer()->notNull(),
            'is_available' => $this->integer(2)->defaultValue(\common\models\Domain::STATUS_UNKNOWN)->comment('0 - занят; 1 - свободен; 2 - неизвестно'),
        ], $tableOptions);

        $this->createIndex(
            'idx-domain-domain',
            'domain',
            'domain'
        );

        $this->createIndex(
            'idx-domain-is_available',
            'domain',
            'is_available'
        );

        $this->createIndex(
            'idx-domain-category_id',
            'domain',
            'category_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%domain}}');
    }
}
