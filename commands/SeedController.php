<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

use app\helpers\DatabaseHelper;

class SeedController extends Controller
{
    
    public function actionUpdateMessages()
    {
        \app\helpers\DatabaseHelper::updateMessages();
        return ExitCode::OK;
    }
}
