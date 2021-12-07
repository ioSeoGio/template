<?php

namespace app\custom;

class DbMessageSource extends \yii\i18n\DbMessageSource {

    /**
     * Loads the messages from database.
     * You may override this method to customize the message storage in the database.
     * @param string $category the message category.
     * @param string $language the target language.
     * @return array the messages loaded from database.
     */
    protected function loadMessagesFromDb($category, $language)
    {
        $mainQuery = (new \yii\db\Query())
            ->select([
                'message' => 'source_message.message', 
                'translation' => 'translation_message.translation'
            ])
            ->from([
                'source_message' => $this->sourceMessageTable, 
                'translation_message' => $this->messageTable
            ])
            ->where([
                'source_message.id' => new \yii\db\Expression('[[translation_message.source_id]]'),
                'source_message.category' => $category,
                'translation_message.language' => $language,
            ]);

        $fallbackLanguage = substr($language, 0, 2);
        $fallbackSourceLanguage = substr($this->sourceLanguage, 0, 2);

        if ($fallbackLanguage !== $language) {
            $mainQuery->union($this->createFallbackQuery($category, $language, $fallbackLanguage), true);
        } elseif ($language === $fallbackSourceLanguage) {
            $mainQuery->union($this->createFallbackQuery($category, $language, $fallbackSourceLanguage), true);
        }

        $messages = $mainQuery->createCommand($this->db)->queryAll();

        return \yii\helpers\ArrayHelper::map($messages, 'message', 'translation');
    }
}