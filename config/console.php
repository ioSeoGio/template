<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$i18n = require __DIR__ . '/i18n.php';
$language = require __DIR__ . '/language_settings.php';

$config = array_merge($language, [
    'id' => 'app',

    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
            'templatePath' => '@tests/unit/templates',
            'language' => 'ru_RU',
            'count' => 5,
        ],
        'batch' => [
            // 'class' => 'schmunk42\giiant\commands\BatchController',
            'class' => 'app\custom\giiant\BatchController',
            'overwrite' => true,
            'crudTidyOutput' => false,
            'interactive' => false,
            
            'modelBaseClass' => 'app\\custom\\ActiveRecord',
            'modelNamespace' => 'app\\models',
            'crudPathPrefix' => null,
            'crudSearchModelNamespace' => 'app\\models\\search',
            
            'crudViewPath' => '@admin/views',
            'crudControllerNamespace' => 'app\\modules\\admin\\controllers',

            'skipTables' => [
                'users', 

                'auth_assignment', 
                'auth_item', 
                'auth_item_child', 
                'auth_rule', 
                'migration'
            ],

            'template' => 'seog_template',
            'crudTemplate' => 'seog_template',
            // whether to overwrite files
            // 'overwrite' => true,

            'crudAccessFilter' => true,
            'generateAccessFilterMigrations' => true,

            // temp off, need to configure
            'useTranslatableBehavior' => false
        ]
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
        '@admin' => '@app/admin',
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['user', 'admin'],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'i18n' => $i18n,
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
]);

if (YII_ENV_DEV) {
    $generators = require __DIR__ . '/gii_generators.php';
    
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',

        'generators' => $generators,
    ];
}

return $config;
