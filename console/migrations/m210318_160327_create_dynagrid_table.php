<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%dynagrid}}`.
 */
class m210318_160327_create_dynagrid_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = '';
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%dynagrid}}', [
            'id' => $this->string(100)->notNull(),
            'filter_id' => $this->string(100),
            'sort_id' => $this->string(100),
            'data' => $this->text()
        ], $tableOptions);

        $this->addPrimaryKey('dynagrid_PK', '{{%dynagrid}}', 'id');

        $this->createTable('{{%dynagrid_dtl}}', [
            'id' => $this->string(100)->notNull(),
            'category' => $this->string(10)->notNull(),
            'name' => $this->string(150)->notNull(),
            'data' => $this->text(),
            'dynagrid_id' => $this->string(100)->notNull()
        ], $tableOptions);

        $this->addPrimaryKey('dynagrid_dtl_PK', '{{%dynagrid_dtl}}', 'id');
        $this->addForeignKey('dynagrid_FK1', '{{%dynagrid}}', 'filter_id', '{{%dynagrid_dtl}}', 'id');
        $this->addForeignKey('dynagrid_FK2', '{{%dynagrid}}', 'sort_id', '{{%dynagrid_dtl}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('dynagrid_FK1', '{{%dynagrid}}');
        $this->dropForeignKey('dynagrid_FK2', '{{%dynagrid}}');
        $this->dropTable('{{%dynagrid}}');
        $this->dropTable('{{%dynagrid_dtl}}');
    }
}
