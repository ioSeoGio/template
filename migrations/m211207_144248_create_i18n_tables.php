<?php

use yii\db\Migration;

use app\helpers\FilesystemHelper;

class m211207_144248_create_i18n_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $mainCategory = Yii::$app->id;
        $mainTranslateLanguage = Yii::$app->language;

        $this->createTable('{{%source_message}}', [
            'id' => $this->primaryKey(),
            'category' => $this->string(32)->notNull()->defaultValue($mainCategory),
            'message' => $this->text()->unique(),
        ]);
        $this->createTable('{{%message}}', [
            'id' => $this->primaryKey(),
            'source_id' => $this->integer(),
            'language' => $this->string()->defaultValue($mainTranslateLanguage),
            'translation' => $this->text()->defaultValue(''),
        ]);

        $this->addForeignKey(
            'FK_message_id_source_message_id', 
            '{{%message}}', 
            'source_id', 
            '{{%source_message}}', 
            'id', 
            'SET NULL', 
            'SET NULL'
        );

        $allLanguagesPairs = FilesystemHelper::getPairsOfTranslations();

        // Be sure that pairs of arrays in allLanguagesPairs = number of languages here
        $languages = $allLanguagesPairs ? [$mainTranslateLanguage] : [];

        $messageIdCounter = 1;
        foreach ($allLanguagesPairs as $message => $translations) {
            $this->insert('{{%source_message}}', ['message' => $message]);

            if (is_array($translations)) {
                // If array of translations
                foreach ($translations as $languageCounter => $translation) {
                    $this->insert('{{%message}}', [
                        'source_id' => $messageIdCounter,
                        'translation' => $translation,

                        'language' => $languages[$languageCounter],
                    ]);
                }
            } else {
                // So that is string - one translation
                $translation = $translations;
                $this->insert('{{%message}}', [
                    'source_id' => $messageIdCounter,
                    'translation' => $translations,

                    'language' => $languages[0],
                ]);
            }

            $messageIdCounter++;
        }
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'FK_message_id_source_message_id', 
            '{{%message}}'
        );
        $this->dropTable('{{%message}}');
        $this->dropTable('{{%source_message}}');
        return true;
    }
}