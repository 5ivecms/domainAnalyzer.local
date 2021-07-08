<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "domain".
 *
 * @property int $id
 * @property string $domain
 * @property int $category_id
 * @property int $is_available
 */
class Domain extends \yii\db\ActiveRecord
{
    const STATUS_NOT_AVAILABLE = 0;
    const STATUS_AVAILABLE = 1;
    const STATUS_UNKNOWN = 2;
    const STATUS_LABELS = [
        self::STATUS_NOT_AVAILABLE => 'Занят',
        self::STATUS_AVAILABLE => 'Свободен',
        self::STATUS_UNKNOWN => 'Неизвестно',
    ];

    public $list;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'domain';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['domain'], 'required'],
            [['category_id', 'is_available'], 'integer'],
            [['domain'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'domain' => 'Домен',
            'category_id' => 'ID категории',
            'is_available' => 'Статус',
        ];
    }

    public function getCategory() {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getLinkpad()
    {
        return $this->hasOne(Linkpad::className(), ['domain_id' => 'id']);
    }

    public function getMegaindex()
    {
        return $this->hasOne(Megaindex::className(), ['domain_id' => 'id']);
    }

    public function getYandex()
    {
        return $this->hasOne(Yandex::className(), ['domain_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $linkpadModel = new Linkpad();
        $linkpadModel->domain_id = $this->id;
        $linkpadModel->save();

        $megaindexModel = new Megaindex();
        $megaindexModel->domain_id = $this->id;
        $megaindexModel->save();

        $yandexModel = new Yandex();
        $yandexModel->domain_id = $this->id;
        $yandexModel->save();

        parent::afterSave($insert, $changedAttributes);
    }
}
