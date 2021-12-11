<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\admin\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/admin/resources';
    public $css = [
        // 'style/css/index.css',

        'style/css/menu.css',
    ];
    public $js = [
        // 'js/index.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',

    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}
