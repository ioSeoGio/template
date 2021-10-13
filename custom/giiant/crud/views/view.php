<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/*
 * @var yii\web\View $this
 * @var schmunk42\giiant\generators\crud\Generator $generator
 */

/** @var \yii\db\ActiveRecord $model */
/** @var $generator \schmunk42\giiant\generators\crud\Generator */

## TODO: move to generator (?); cleanup
$model = new $generator->modelClass();
$model->setScenario('crud');
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $model->setScenario('default');
    $safeAttributes = $model->safeAttributes();
}
if (empty($safeAttributes)) {
    $safeAttributes = $model->getTableSchema()->columnNames;
}

$modelName = Inflector::camel2words(StringHelper::basename($model::className()));
$className = $model::className();
$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;

/**
* @var yii\web\View $this
* @var <?= ltrim($generator->modelClass, '\\') ?> $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('<?= $generator->modelMessageCategory ?>', '<?= $modelName ?>');
$this->params['breadcrumbs'][] = ['label' => Yii::t('<?= $generator->modelMessageCategory ?>', '<?= Inflector::pluralize($modelName) ?>'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model-><?= $generator->getNameAttribute() ?>, 'url' => ['view', <?= $urlParams ?>]];
$this->params['breadcrumbs'][] = <?= $generator->generateString('View') ?>;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass), '-', true) ?>-view">


    <h1>
        <?= "<?= Yii::t('{$generator->modelMessageCategory}', '{$modelName}') ?>\n" ?>
        <small>
            <?= '<?= Html::encode($model->'.$generator->getModelNameAttribute($generator->modelClass).") ?>\n" ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= '<?= ' ?>Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . <?= $generator->generateString('Edit') ?>,
            [ 'update', <?= $urlParams ?>],
            ['class' => 'btn btn-info']) ?>

            <?= '<?= ' ?>Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . <?= $generator->generateString('Copy') ?>,
            ['create', <?= $urlParams ?>, '<?= StringHelper::basename($generator->modelClass) ?>'=>$copyParams],
            ['class' => 'btn btn-success']) ?>

            <?= '<?= ' ?>Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . <?= $generator->generateString('New') ?>,
            ['create'],
            ['class' => 'btn btn-success']) ?>
        </div>

        <div class="pull-right">
            <?= "<?= " ?>Html::a('<span class="glyphicon glyphicon-list"></span> '
            . <?= $generator->generateString('Full list') ?>, ['index'], ['class'=>'btn btn-primary']) ?>
        </div>

    </div>

    <hr/>

    <?= '<?= ' ?>DetailView::widget([
    'model' => $model,
    'attributes' => [
    <?php
    foreach ($safeAttributes as $attribute) {
        $format = $generator->attributeFormat($attribute);
        if (!$format) {
            continue;
        } else {
            echo $format.",\n";
        }
    }
    ?>
    ],
    ]); ?>

    <hr/>

    <?= '<?= ' ?>Html::a('<span class="glyphicon glyphicon-trash"></span> ' . <?= $generator->generateString(
        'Delete'
    ) ?>, ['delete', <?= $urlParams ?>],
    [
    'class' => 'btn btn-danger',
    'data-confirm' => '' . <?= $generator->generateString('Are you sure to delete this item?') ?> . '',
    'data-method' => 'post',
    ]); ?>


</div>
