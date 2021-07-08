<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%megaindex}}`.
 */
class m210512_044912_add_increasing_search_traffic_column_to_megaindex_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%megaindex}}', 'increasing_search_traffic', $this->integer()->defaultValue(0)->after('organic_traffic'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%megaindex}}', 'increasing_search_traffic');
    }
}
