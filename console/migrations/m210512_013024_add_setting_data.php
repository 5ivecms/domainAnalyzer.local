<?php

use yii\db\Migration;

/**
 * Class m210512_013024_add_setting_data
 */
class m210512_013024_add_setting_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%setting}}', [
            'option' => 'megaindex.proxy.enabled',
            'value' => 1,
            'default' => 1,
            'label' => 'Включено'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210512_013024_add_setting_data cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210512_013024_add_setting_data cannot be reverted.\n";

        return false;
    }
    */
}
