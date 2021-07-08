<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%useragent}}`.
 */
class m210306_092039_create_useragent_table extends Migration
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

        $this->createTable('{{%useragent}}', [
            'id' => $this->primaryKey(),
            'useragent' => $this->text()
        ], $tableOptions);

        $this->insert('{{%useragent}}', [
            'useragent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.190 Safari/537.36',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%useragent}}');
    }
}
