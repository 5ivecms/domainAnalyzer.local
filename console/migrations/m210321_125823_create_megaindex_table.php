<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%megaindex}}`.
 */
class m210321_125823_create_megaindex_table extends Migration
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

        $this->createTable('{{%megaindex}}', [
            'id' => $this->primaryKey(),
            'domain_id' => $this->integer()->notNull(),
            'total_self_uniq_links' => $this->integer()->defaultValue(0),
            'total_anchors_unique' => $this->integer()->defaultValue(0),
            'total_self_domains' => $this->integer()->defaultValue(0),
            'trust_rank' => $this->integer()->defaultValue(0),
            'domain_rank' => $this->integer()->defaultValue(0),
            'is_completed' => $this->integer(1)->defaultValue(0)
        ], $tableOptions);

        $this->createIndex(
            'idx-megaindex-domain_id',
            'megaindex',
            'domain_id',
            true
        );

        $this->addForeignKey(
            '{{%fk-megaindex-domain_id}}',
            '{{%megaindex}}',
            'domain_id',
            '{{%domain}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-megaindex-total_self_uniq_links',
            'megaindex',
            'total_self_uniq_links'
        );

        $this->createIndex(
            'idx-megaindex-total_anchors_unique',
            'megaindex',
            'total_anchors_unique'
        );

        $this->createIndex(
            'idx-megaindex-total_self_domains',
            'megaindex',
            'total_self_domains'
        );

        $this->createIndex(
            'idx-megaindex-trust_rank',
            'megaindex',
            'trust_rank'
        );

        $this->createIndex(
            'idx-megaindex-domain_rank',
            'megaindex',
            'domain_rank'
        );

        $this->createIndex(
            'idx-megaindex-is_completed',
            'megaindex',
            'is_completed'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%megaindex}}');
    }
}
