<?php

namespace app\modules\admin;

use Yii;
use yii\helpers\Url;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\admin\controllers';

    public function init()
    {
        parent::init();
    }

    public function beforeAction($action)
    {
        Yii::$app->errorHandler->errorAction = Url::to(['/admin/default/error']);
        Yii::$app->controller->layout = 'main';

        if (!parent::beforeAction($action)) {
            return false;
        }
        
        if (!Yii::$app->user->can('admin')) {
            throw new \yii\web\ForbiddenHttpException('Вам сюда нельзя.');
        }
        return true;
    }

}
