<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$i18n = require __DIR__ . '/i18n.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'controllerMap' => [
        'batch' => [
            'class' => 'schmunk42\giiant\commands\BatchController',
            // 'class' => 'app\custom\giiant\BatchController',
            'overwrite' => true,
            'crudTidyOutput' => false,

            'modelNamespace' => 'app\\models',
            'crudControllerNamespace' => 'app\\controllers',
            'crudSearchModelNamespace' => 'app\\models\\search',
            'crudViewPath' => '@app/views',
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
            // 'overwrite' => true,

            'crudAccessFilter' => true,
            'generateAccessFilterMigrations' => false,

            // temp off, need to configure
            'useTranslatableBehavior' => false
        ]
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
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
];

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
