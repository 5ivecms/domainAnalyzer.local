<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%megaindex}}`.
 */
class m210512_045204_add_popular_keywords_column_to_megaindex_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%megaindex}}', 'popular_keywords', $this->integer()->defaultValue(0)->after('increasing_search_traffic'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%megaindex}}', 'popular_keywords');
    }
}
