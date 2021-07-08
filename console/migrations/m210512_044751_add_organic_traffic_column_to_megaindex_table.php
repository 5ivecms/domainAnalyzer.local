<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%megaindex}}`.
 */
class m210512_044751_add_organic_traffic_column_to_megaindex_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%megaindex}}', 'organic_traffic', $this->integer()->defaultValue(0)->after('domain_rank'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%megaindex}}', 'organic_traffic');
    }
}
