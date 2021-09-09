<?php
namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class AngularAsset extends AssetBundle
{
    public $sourcePath = "@bower";
    public $js = [
        'angular/angular.js',
        'angular-route/angular-route.js',
    ];
    public $jsOptions = [
        // 'position' => View::POS_READY,
    ];
}
