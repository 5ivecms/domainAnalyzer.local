<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%linkpad}}`.
 */
class m210312_073022_create_linkpad_table extends Migration
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

        $this->createTable('{{%linkpad}}', [
            'id' => $this->primaryKey(),
            'domain_id' => $this->integer()->notNull(),
            'linkpad_rank' => $this->integer()->defaultValue(0),
            'backlinks' => $this->integer()->defaultValue(0),
            'nofollow_links' => $this->integer()->defaultValue(0),
            'no_anchor_links' => $this->integer()->defaultValue(0),
            'count_ips' => $this->integer()->defaultValue(0),
            'count_subnet' => $this->integer()->defaultValue(0),
            'cost_links' => $this->integer()->defaultValue(0),
            'referring_domains' => $this->integer()->defaultValue(0),
            'domain_links_ru' => $this->float()->defaultValue(0),
            'domain_links_rf' => $this->float()->defaultValue(0),
            'domain_links_com' => $this->float()->defaultValue(0),
            'domain_links_su' => $this->float()->defaultValue(0),
            'domain_links_other' => $this->float()->defaultValue(0),
            'is_completed' => $this->integer(1)->defaultValue(0)
        ], $tableOptions);

        $this->createIndex(
            'idx-linkpad-domain_id',
            'linkpad',
            'domain_id',
            true
        );

        $this->addForeignKey(
            '{{%fk-linkpad-domain_id}}',
            '{{%linkpad}}',
            'domain_id',
            '{{%domain}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-linkpad-linkpad_rank',
            'linkpad',
            'linkpad_rank'
        );

        $this->createIndex(
            'idx-linkpad-backlinks',
            'linkpad',
            'backlinks'
        );

        $this->createIndex(
            'idx-linkpad-no_anchor_links',
            'linkpad',
            'no_anchor_links'
        );

        $this->createIndex(
            'idx-linkpad-nofollow_links',
            'linkpad',
            'nofollow_links'
        );

        $this->createIndex(
            'idx-linkpad-count_ips',
            'linkpad',
            'count_ips'
        );

        $this->createIndex(
            'idx-linkpad-count_subnet',
            'linkpad',
            'count_subnet'
        );

        $this->createIndex(
            'idx-linkpad-cost_links',
            'linkpad',
            'cost_links'
        );

        $this->createIndex(
            'idx-linkpad-referring_domains',
            'linkpad',
            'referring_domains'
        );

        $this->createIndex(
            'idx-linkpad-is_completed',
            'linkpad',
            'is_completed'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%linkpad}}');
    }
}
