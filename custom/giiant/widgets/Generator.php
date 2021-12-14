<?php

namespace app\custom\giiant\widgets;

use Yii;
use yii\gii\CodeFile;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

class Generator extends \yii\gii\Generator
{
	public $singularEntities;
	public $overwriteAdminMenu = false;
	public $adminWidgetsNamespace = '@admin/widgets/';

	public $tables;
	public $controllers;
	public $controllerClass;

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'SeoG Widgets';
    }

    /**
     * @return string the controller ID (without the module ID prefix)
     */
    public function getControllerID()
    {
        $pos = strrpos($this->controllerClass, '\\');
        if ($pos) {
        	$class = substr(substr($this->controllerClass, $pos + 1), 0, -10);
        } else {
        	$class = $this->controllerClass;
        }
        if ($this->singularEntities) {
            $class = Inflector::singularize($class);
        }

        return Inflector::camel2id($class, '-', true);
    }

    public function getControllerAccessDefinitions()
    {
    	return require $this->getTemplatePath().'/../crud/access_definition.php';
    }

	public function generate()
	{	
		$data = [];
		foreach ($this->controllers as $controllerName) {
			$this->controllerClass = $controllerName;

			$data[] = array_merge($this->getControllerAccessDefinitions(), [
				'controller' => Inflector::camel2words($this->controllerClass),
				'controllerID' => $this->getControllerID(),
			]);
		}
        $params['data'] = $data;
        // Admin menu widgets
        $adminMenuFile = Yii::getAlias($this->adminWidgetsNamespace).'Menu.php';
        
        if ($this->overwriteAdminMenu || !is_file($adminMenuFile)) {
            $files[] = new CodeFile($adminMenuFile, $this->render('admin-menu.php', $params));
        }

        return $files;
	}
}