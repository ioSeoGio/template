<?php 

$fileConfig = [
    'class' => 'yii\i18n\PhpMessageSource',
    'basePath' => '@app/message',
    'sourceLanguage' => 'en-US',
    'fileMap' => [
        'models' => 'models.php',
        'cruds' => 'cruds.php',
    ],
];

$dbConfig = [
    // 'class' => 'yii\i18n\DbMessageSource',
    'class' => 'app\custom\DbMessageSource',
    'messageTable' => '{{%message}}',
    'sourceMessageTable' => '{{%source_message}}',

    'sourceLanguage' => 'en-US',

    'enableCaching' => true,
    'cachingDuration' => 10,
    'forceTranslation'=> true,
];

return [
    'translations' => [
        'app' => $dbConfig,
        'models' => $fileConfig,
        'cruds' => $fileConfig,
    ],
];