<?php

namespace app\custom\giiant;

use yii\helpers\Inflector;

/**
 * @author ioSeoGio
 * 
 * Check if config/console.php controllerMap batch has this class before configuring this class
 */
class BatchController extends \schmunk42\giiant\commands\BatchController
{
    public $overwriteAdminMenu = false;

    public function actionIndex()
    {
        // echo "Running full giiant batch...\n";
        // $this->actionModels();
        // $this->actionCruds();
        parent::actionIndex();

        $this->actionAdminMenu();
    }

    public function actionAdminMenu()
    {
        foreach ($this->tables as $tableName) {
            if (isset($this->tableNameMap[$tableName])) {
                $tmp_name = $this->tableNameMap[$tableName];
            } else {
                $tmp_name = str_replace($this->tablePrefix, '', $tableName);
            }
            $controllerName = $this->modelGenerator->generateClassName($tmp_name);
            $controllers[] = $controllerName;
        }

        $params = [
            'controllers' => $controllers,
            'tables' => $this->tables,

            'singularEntities' => $this->singularEntities,
            'interactive' => $this->interactive,
            'overwrite' => $this->overwrite,
            'template' => $this->template,
            'overwriteAdminMenu' => $this->overwriteAdminMenu,
        ];

        $route = 'gii/seog-widget';

        $app = \Yii::$app;
        $temp = new \yii\console\Application($this->appConfig);
        $temp->runAction(ltrim($route, '/'), $params);
        $temp->get($this->modelDb)->close();
        unset($temp);
        \Yii::$app = $app;
        \Yii::$app->log->logger->flush(true);
    }
}

