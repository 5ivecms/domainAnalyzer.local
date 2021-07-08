<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%setting}}`.
 */
class m201007_185448_create_setting_table extends Migration
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

        $this->createTable('{{%setting}}', [
            'id' => $this->primaryKey(),
            'option' => $this->string(255),
            'value' => $this->text(),
            'default' => $this->text(),
            'label' => $this->text(),
        ], $tableOptions);

        $this->createIndex(
            'idx-setting-option',
            'setting',
            'option',
            true
        );

        // Настройки кеширования
        $this->insert('{{%setting}}', [
            'option' => 'cache.duration',
            'value' => 30,
            'default' => 30,
            'label' => 'Длительность кеширования (секунды)'
        ]);

        $this->insert('{{%setting}}', [
            'option' => 'cache.enabled',
            'value' => 0,
            'default' => 0,
            'label' => 'Включить кеширование'
        ]);

        $this->insert('{{%setting}}', [
            'option' => 'proxy.enabled',
            'value' => 1,
            'default' => 1,
            'label' => 'Использоивать прокси'
        ]);

        $this->insert('{{%setting}}', [
            'option' => 'proxy.url',
            'value' => 'https://api.best-proxies.ru/proxylist.json?key=0326e188e3c03bfa8bd6a2a7295cb399&type=socks4&level=1,2&speed=1&uptime=1&country=ru&limit=0',
            'default' => 'https://api.best-proxies.ru/proxylist.json?key=0326e188e3c03bfa8bd6a2a7295cb399&type=socks4&level=1,2&speed=1&uptime=1&country=ru&limit=0',
            'label' => 'URL со списком прокси'
        ]);

        $this->insert('{{%setting}}', [
            'option' => 'proxy.timeout',
            'value' => 7,
            'default' => 7,
            'label' => 'Таймаут (сек)'
        ]);

        $this->insert('{{%setting}}', [
            'option' => 'proxy.ping',
            'value' => 500,
            'default' => 500,
            'label' => 'Допустимый пинг, ms'
        ]);

        $this->insert('{{%setting}}', [
            'option' => 'proxy.api.enabled',
            'value' => 1,
            'default' => 1,
            'label' => 'Использовать API'
        ]);

        $this->insert('{{%setting}}', [
            'option' => 'proxy.api.name',
            'value' => 'best-proxies.ru',
            'default' => 'best-proxies.ru',
            'label' => 'API'
        ]);

        $this->insert('{{%setting}}', [
            'option' => 'proxy.api.url',
            'value' => 'https://api.best-proxies.ru/proxylist.json?key=85f5ae363820309b0c825f6cb6a07fe9&type=socks4&level=1,2&speed=1&uptime=1&country=ru&limit=0',
            'default' => 'https://api.best-proxies.ru/proxylist.json?key=85f5ae363820309b0c825f6cb6a07fe9&type=socks4&level=1,2&speed=1&uptime=1&country=ru&limit=0',
            'label' => 'URL со списком прокси (json)'
        ]);

        // Настройки парсера
        $this->insert('{{%setting}}', [
            'option' => 'parser.enabled',
            'value' => 1,
            'default' => 1,
            'label' => 'Включить парсер'
        ]);

        $this->insert('{{%setting}}', [
            'option' => 'parser.tryLimit',
            'value' => 20,
            'default' => 20,
            'label' => 'Максимальное количество попыток'
        ]);

        $this->insert('{{%setting}}', [
            'option' => 'parser.autoRefresh.enabled',
            'value' => 0,
            'default' => 0,
            'label' => 'Автообновление сетки'
        ]);

        $this->insert('{{%setting}}', [
            'option' => 'parser.autoRefresh.timeout',
            'value' => 5,
            'default' => 5,
            'label' => 'Таймаут автообновения (сек)'
        ]);

        $this->insert('{{%setting}}', [
            'option' => 'parser.linkpad.isProcess',
            'value' => 0,
            'default' => 0,
            'label' => 'Запущен'
        ]);

        $this->insert('{{%setting}}', [
            'option' => 'parser.megaindex.isProcess',
            'value' => 0,
            'default' => 0,
            'label' => 'Запущен'
        ]);

        $this->insert('{{%setting}}', [
            'option' => 'parser.available.isProcess',
            'value' => 0,
            'default' => 0,
            'label' => 'Запущен'
        ]);

        $this->insert('{{%setting}}', [
            'option' => 'parser.yandexSqi.isProcess',
            'value' => 0,
            'default' => 0,
            'label' => 'Запущен'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%setting}}');
    }
}
