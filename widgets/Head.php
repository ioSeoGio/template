<?php

namespace app\widgets;

use yii\base\Widget;

class Head extends Widget
{
    public $layoutView;

    public function run()
    {
        return $this->render('head', [
            'layoutView' => $this->layoutView,
        ]);
    }
}