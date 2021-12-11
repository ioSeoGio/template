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
            'Тест' => [
                'Тест' => Url::to(['test/test']),
            ],
            'Прочее' => [
                'Тест' => Url::to(['test/test']),
            ],
            'Без группы' => [
            ],
        ];

        
        return $this->render('menu', [
            'content' => $content,
            'menu' => $menu,
        ]);
    }
}

 ?>
