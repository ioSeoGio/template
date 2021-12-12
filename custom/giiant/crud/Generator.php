<?php

namespace app\custom\giiant\crud;

use Yii;
use yii\gii\CodeFile;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use schmunk42\giiant\helpers\SaveForm;

class Generator extends \schmunk42\giiant\generators\crud\Generator
{
    /**
     * @var bool whether generate messages for translations for crud
     */
    public $generateMessages = false;
    public $apiControllersNamespace = '@app/controllers/api/';
    public $migrationsNamespace = '@app/migrations/';

    public function generate()
    {
        $accessDefinitions = require $this->getTemplatePath().'/access_definition.php';

        $this->controllerNs = \yii\helpers\StringHelper::dirname(ltrim($this->controllerClass, '\\'));
        $this->moduleNs = \yii\helpers\StringHelper::dirname(ltrim($this->controllerNs, '\\'));
        $controllerName = substr(\yii\helpers\StringHelper::basename($this->controllerClass), 0, -10);

        if ($this->singularEntities) {
            $this->modelClass = Inflector::singularize($this->modelClass);
            $this->controllerClass = Inflector::singularize(
                    substr($this->controllerClass, 0, strlen($this->controllerClass) - 10)
                ).'Controller';
            $this->searchModelClass = Inflector::singularize($this->searchModelClass);
        }

        $controllerFile = Yii::getAlias('@'.str_replace('\\', '/', ltrim($this->controllerClass, '\\')).'.php');
        // $baseControllerFile = StringHelper::dirname($controllerFile).'/base/'.StringHelper::basename($controllerFile);
        $restControllerFile = Yii::getAlias($this->apiControllersNamespace).StringHelper::basename($controllerFile);

        /*
         * search generated migration and overwrite it or create new
         */
        // $migrationDir = StringHelper::dirname(StringHelper::dirname($controllerFile)).'/migrations';
        $migrationDir = Yii::getAlias($this->migrationsNamespace);

        if (file_exists($migrationDir) && $migrationDirFiles = glob($migrationDir.'/m*_'.$controllerName.'00_access.php')) {
            $this->migrationClass = pathinfo($migrationDirFiles[0], PATHINFO_FILENAME);
        } else {
            $this->migrationClass = 'm'.date('ymd_Hi').'00_'.Inflector::underscore($controllerName).'_rbac';
        }

        // $files[] = new CodeFile($baseControllerFile, $this->render('controller.php', ['accessDefinitions' => $accessDefinitions]));
        $params['controllerClassName'] = \yii\helpers\StringHelper::basename($this->controllerClass);
        $params['accessDefinitions'] = $accessDefinitions;

        if ($this->overwriteControllerClass || !is_file($controllerFile)) {
            $files[] = new CodeFile($controllerFile, $this->render('controller-extended.php', $params));
        }

        if ($this->overwriteRestControllerClass || !is_file($restControllerFile)) {
            $files[] = new CodeFile($restControllerFile, $this->render('controller-rest.php', $params));
        }

        if (!empty($this->searchModelClass)) {
            $searchModel = Yii::getAlias('@'.str_replace('\\', '/', ltrim($this->searchModelClass, '\\').'.php'));
            if ($this->overwriteSearchModelClass || !is_file($searchModel)) {
                $files[] = new CodeFile($searchModel, $this->render('search.php'));
            }
        }

        $viewPath = $this->getViewPath();
        $templatePath = $this->getTemplatePath().'/views';

        foreach (scandir($templatePath) as $file) {
            if (empty($this->searchModelClass) && $file === '_search.php') {
                continue;
            }
            if (is_file($templatePath.'/'.$file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $files[] = new CodeFile("$viewPath/$file", $this->render("views/$file", ['permisions' => $permisions]));
            }
        }

        if ($this->generateAccessFilterMigrations) {

            /*
             * access migration
             */
            $migrationFile = $migrationDir.'/'.$this->migrationClass.'.php';
            $files[] = new CodeFile($migrationFile, $this->render('migration_access.php', ['accessDefinitions' => $accessDefinitions]));

            if ($this->generateMessages) {
                /*
                 * access roles translation
                 */
                $forRoleTranslationFile = StringHelper::dirname(StringHelper::dirname($controllerFile))
                    .'/messages/for-translation/'
                    .$controllerName.'.php';
                $files[] = new CodeFile($forRoleTranslationFile, $this->render('roles-translation.php', ['accessDefinitions' => $accessDefinitions]));
            }
        }

        /*
         * create gii/[name]GiantCRUD.json with actual form data
         */
        // $suffix = str_replace(' ', '', $this->getName());
        // $controllerFileinfo = pathinfo($controllerFile);
        // $formDataFile = StringHelper::dirname(StringHelper::dirname($controllerFile))
                // .'/gii/'
                // .str_replace('Controller', $suffix, $controllerFileinfo['filename']).'.json';
        //$formData = json_encode($this->getFormAttributesValues());
        // $formData = json_encode(SaveForm::getFormAttributesValues($this, $this->formAttributes()));
        // $files[] = new CodeFile($formDataFile, $formData);

        return $files;
    }

    // TODO: replace with VarDumper::export
    public function var_export54($var, $indent = '')
    {
        switch (gettype($var)) {
            case 'string':
                return "'".addcslashes($var, "\\\$\"\r\n\t\v\f")."'";
            case 'array':
                $indexed = array_keys($var) === range(0, count($var) - 1);
                $r = [];
                foreach ($var as $key => $value) {
                    $r[] = "$indent    "
                         .($indexed ? '' : $this->var_export54($key).' => ')
                         .$this->var_export54($value, "$indent    ");
                }

                return "[\n".implode(",\n", $r)."\n".$indent.']';
            case 'boolean':
                return $var ? 'TRUE' : 'FALSE';
            default:
                return var_export($var, true);
        }
    }
}
