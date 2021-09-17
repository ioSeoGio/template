<?php

use yii\helpers\StringHelper;

/*
 * This is the template for generating a CRUD controller class file.
 *
 * @var yii\web\View $this
 * @var schmunk42\giiant\generators\crud\Generator $generator
 */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
$searchModelClassName = $searchModelClass;
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass.'Search';
    $searchModelClassName = $searchModelAlias;
}

// TODO: improve detetction of NOSQL primary keys
if ($generator->getTableSchema()) {
    $pks = $generator->getTableSchema()->primaryKey;
} else {
    $pks = ['_id'];
}

$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();
echo "<?php\n";
?>
// This class was automatically generated
// You should not change it manually as it will be overwritten on next build

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>\base;

use yii\web\HttpException;
use <?= ltrim($generator->baseControllerClass, '\\') ?>;
use yii\helpers\Url;
use yii\filters\AccessControl;

use <?= ltrim($generator->modelClass, '\\') ?>;
<?php if ($searchModelClass !== ''): ?>
use <?= ltrim(
    $generator->searchModelClass,
    '\\'
) ?><?php if (isset($searchModelAlias)): ?> as <?= $searchModelAlias ?><?php endif ?>;
<?php endif; ?>

/**
* <?= $controllerClass ?> implements the CRUD actions for <?= $modelClass ?> model.
*/
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass)."\n" ?>
{
<?php
$traits = $generator->baseTraits;
if ($traits) {
    echo "use {$traits};";
}
?>

<?php if ($generator->accessFilter): ?>
    /**
    * @inheritdoc
    */
    public function behaviors()
    {
        return [];
    }

    public function access_rules()
    {
        return [
<?php foreach($accessDefinitions['roles'] as $roleName => $actions): ?>
            [
                'allow' => true,
                'actions' => ['<?=implode("', '",$actions)?>'],
                'roles' => ['<?=$roleName?>'],
            ],
<?php endforeach; ?>
        ];
    }

<?php endif; ?>

    /**
    * Lists all <?= $modelClass ?> models.
    * @return mixed
    */
    public function actionIndex()
    {
<?php if ($searchModelClass !== ''): ?>
        $searchModel  = new <?= $searchModelClassName ?>;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
<?php else: ?>
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => <?= $modelClass ?>::find(),
        ]);
<?php endif; ?>

        return $this->render('index', [
            'dataProvider' => $dataProvider,
<?php if ($searchModelClass !== ''): ?>
            'searchModel' => $searchModel,
<?php endif; ?>
        ]);
    }

    /**
    * Displays a single <?= $modelClass ?> model.
    * <?= implode("\n\t * ", $actionParamComments)."\n" ?>
    *
    * @return mixed
    */
    public function actionView(<?= $actionParams ?>)
    {
        return $this->render('view', [
            'model' => $this->findModel(<?= $actionParams ?>),
        ]);
    }

    /**
    * Creates a new <?= $modelClass ?> model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    * @return mixed
    */
    public function actionCreate()
    {
        $model = new <?= $modelClass ?>();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', <?= $urlParams ?>]);
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
    * Updates an existing <?= $modelClass ?> model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * <?= implode("\n\t * ", $actionParamComments)."\n" ?>
    * @return mixed
    */
    public function actionUpdate(<?= $actionParams ?>)
    {
        $model = $this->findModel(<?= $actionParams ?>);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Url::previous());
        }
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
    * Deletes an existing <?= $modelClass ?> model.
    * If deletion is successful, the browser will be redirected to the 'index' page.
    * <?= implode("\n\t * ", $actionParamComments)."\n" ?>
    * @return mixed
    */
    public function actionDelete(<?= $actionParams ?>)
    {
        $this->findModel(<?= $actionParams ?>)->delete();
        
        return $this->redirect(Url::previous());
    }

    /**
    * Finds the <?= $modelClass ?> model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * <?= implode("\n\t * ", $actionParamComments)."\n" ?>
    * @return <?= $modelClass ?> the loaded model
    * @throws HttpException if the model cannot be found
    */
    protected function findModel(<?= $actionParams ?>)
    {
        <?php if (count($pks) === 1) {
            $condition = '$'.$pks[0];
        } else {
            $condition = [];
            foreach ($pks as $pk) {
                $condition[] = "'$pk' => \$$pk";
            }
            $condition = '['.implode(', ', $condition).']';
        } ?>
if (($model = <?= $modelClass ?>::findOne(<?= $condition ?>)) !== null) {
            return $model;
        } else {
            throw new HttpException(404, 'The requested page does not exist.');
        }
    }
}
