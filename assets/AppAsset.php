<?php

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
        'js/app.js',
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        
        'app\assets\AngularAsset',
    ];

    public function init() {
        // In JS use: yiiGlobal.test, etc.
        $options = [
            'test' => Url::to(['test/test']),
            
            'authKey' => Yii::$app->user->identity?->access_token,
        ];
        Yii::$app->view->registerJs(
            "const yiiGlobal = " . Json::htmlEncode($options).";",
            View::POS_HEAD,
            'yiiGlobal'
        );
    }
}
