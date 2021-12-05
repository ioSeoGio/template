<?php

namespace app\widgets;

use yii\base\Widget;

class Footer extends Widget
{

    public function run()
    {
        return $this->render('footer', [
        ]);
    }
}