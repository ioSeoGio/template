<?php

namespace app\modules\admin\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;

class Menu extends Widget
{
    const WITHOUT_GROUP = 'Без группы';

    public function init()
    {
        parent::init();
        ob_start();
    }

    public function run()
    {
        $content = ob_get_clean();

        $menu = [
            'Без группы' => [
                Yii::t('cruds', 'Дефаулт') => Url::to(['/admin/default/index']),
            ],
        ];

        
        return $this->render('menu', [
            'widgetClass' => $this->className(),

            'content' => $content,
            'menu' => $menu,
        ]);
    }
}

 ?>
