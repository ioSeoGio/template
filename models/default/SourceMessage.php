<?php

namespace app\models\default;

use Yii;

/**
 * This is the model class for table "source_message".
 *
 * @property int $id
 * @property string $category
 * @property string|null $message
 *
 * @property Message $message0
 */
class SourceMessage extends \app\custom\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'source_message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message'], 'string'],
            [['category'], 'string', 'max' => 32],
            [['message'], 'unique'],
        ];
    }

    /**
     * Gets query for message.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessage()
    {
        return $this->hasOne(Message::className(), ['id' => 'id']);
    }
}
