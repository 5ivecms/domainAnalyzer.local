<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%yandex}}`.
 */
class m210323_152624_create_yandex_table extends Migration
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

        $this->createTable('{{%yandex}}', [
            'id' => $this->primaryKey(),
            'domain_id' => $this->integer()->notNull(),
            'sqi' => $this->integer()->defaultValue(0),
            'is_completed_sqi' => $this->integer(1)->defaultValue(0),
        ], $tableOptions);

        $this->createIndex(
            'idx-yandex-domain_id',
            'yandex',
            'domain_id',
            true
        );

        $this->addForeignKey(
            '{{%fk-yandex-domain_id}}',
            '{{%yandex}}',
            'domain_id',
            '{{%domain}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-yandex-sqi',
            'yandex',
            'sqi'
        );

        $this->createIndex(
            'idx-yandex-is_completed_sqi',
            'yandex',
            'is_completed_sqi'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%yandex}}');
    }
}
