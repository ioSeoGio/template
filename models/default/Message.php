<?php

namespace app\models\default;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property int $id
 * @property string|null $language
 * @property string|null $translation
 *
 * @property SourceMessage $id0
 */
class Message extends \app\custom\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['source_id'], 'integer'],
            [['translation'], 'string'],
            [['translation'], 'unique'],
            [['language', 'source_id'], 'unique', 'targetAttribute' => ['language', 'source_id']],
            [['language'], 'string', 'max' => 255],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => SourceMessage::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * Gets query for source message.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSourceMessage()
    {
        return $this->hasOne(SourceMessage::className(), ['id' => 'id']);
    }
}
