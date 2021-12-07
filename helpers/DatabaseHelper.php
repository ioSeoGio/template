<?php

namespace app\helpers;

use Yii;

class DatabaseHelper {

    public static function updateMessages()
    {
        $allLanguagesPairs = FilesystemHelper::getPairsOfTranslations();

        // Be sure that pairs of arrays in allLanguagesPairs = number of languages here
        $languages = [$mainTranslateLanguage];

        $messageIdCounter = 1;
        foreach ($allLanguagesPairs as $message => $translations) {
            $model = new SourceMessage([
                'message' => $message,
            ])->saveOrUpdate();

            if (is_array($translations)) {
                // If array of translations
                foreach ($translations as $languageCounter => $translation) {
                    $model = new Message([
                        'source_id' => $messageIdCounter,
                        'translation' => $translations,

                        'language' => $languages[$languageCounter],
                    ])->saveOrUpdate();
                }
            } else {
                // So that is string - one translation
                $translation = $translations;
                
                $model = new Message([
                    'source_id' => $messageIdCounter,
                    'translation' => $translations,

                    'language' => $languages[0],
                ])->saveOrUpdate();
            }

            $messageIdCounter++;
        }
    }

}
