<?php

namespace app\modules\admin\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;

class Menu extends Widget
{
    public function init()
    {
        parent::init();
        ob_start();
    }

    public function run()
    {
        $content = ob_get_clean();

        $menu = [
            Yii::t('cruds', 'Test') => [
                [
                    'name' => Yii::t('app', 'Test'),
                    'url' => Url::to(['default/index']),
                    'can' => Yii::$app->user->can('test') ?: true,
                ],
            ],
        ];
        
        return $this->render('menu', [
            'content' => $content,
            'menu' => $menu,
        ]);
    }
}
