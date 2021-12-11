<?php 

return [
    'translations' => [
        // 'app' => [
        '*' => [
            // 'class' => 'yii\i18n\DbMessageSource',
            'class' => 'app\custom\DbMessageSource',
            'messageTable' => '{{%message}}',
            'sourceMessageTable' => '{{%source_message}}',

            'sourceLanguage' => 'ru-RU',

            'enableCaching' => true,
            'cachingDuration' => 10,
            'forceTranslation'=> true,
        ],
    ],
];