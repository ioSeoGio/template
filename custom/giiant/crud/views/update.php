<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/*
 * @var yii\web\View $this
 * @var yii\gii\generators\crud\Generator $generator
 */

$urlParams = $generator->generateUrlParams();
$model = new $generator->modelClass();
$model->setScenario('crud');
$className = $model::className();
$modelName = Inflector::camel2words(StringHelper::basename($model::className()));

$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $model->setScenario('default');
    $safeAttributes = $model->safeAttributes();
}
if (empty($safeAttributes)) {
    $safeAttributes = $model->getTableSchema()->columnNames;
}

echo "<?php\n";
?>

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var <?= ltrim($generator->modelClass, '\\') ?> $model
*/

$this->title = Yii::t('<?= $generator->modelMessageCategory ?>', '<?= $modelName ?>');
$this->params['breadcrumbs'][] = ['label' => Yii::t('<?= $generator->modelMessageCategory ?>', '<?= $modelName ?>'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model-><?= $generator->getNameAttribute(
) ?>, 'url' => ['view', <?= $urlParams ?>]];
$this->params['breadcrumbs'][] = <?= $generator->generateString('Edit') ?>;
?>
<div class="giiant-crud <?= Inflector::camel2id(StringHelper::basename($generator->modelClass), '-', true) ?>-update">

    <h1>
        <?= "<?= Yii::t('{$generator->modelMessageCategory}', '{$modelName}') ?>" ?>

        <small>
            <?php $label = StringHelper::basename($generator->modelClass); ?>
            <?= '<?= Html::encode($model->'.$generator->getModelNameAttribute($generator->modelClass).") ?>\n" ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= '<?= ' ?>Html::a('<span class="glyphicon glyphicon-file"></span> ' . <?= $generator->generateString(
            'View'
        ) ?>, ['view', <?= $urlParams ?>], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />




    <div class="<?= \yii\helpers\Inflector::camel2id(
        StringHelper::basename($generator->modelClass),
        '-',
        true
    ) ?>-form">

        <?= '<?php ' ?>$form = ActiveForm::begin([
        'id' => '<?= $model->formName() ?>',
        'layout' => '<?= $generator->formLayout ?>',
        'enableClientValidation' => true,
        'errorSummaryCssClass' => 'error-summary alert alert-danger',
        'fieldConfig' => [
                 'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                 'horizontalCssClasses' => [
                     'label' => 'col-sm-2',
                     #'offset' => 'col-sm-offset-4',
                     'wrapper' => 'col-sm-8',
                     'error' => '',
                     'hint' => '',
                 ],
             ],
        ]
        );
        ?>

        <div class="">

            <p>
                <?php
                foreach ($safeAttributes as $attribute) {
                    echo "\n\n<!-- attribute $attribute -->";
                    $prepend = $generator->prependActiveField($attribute, $model);
                    $field = $generator->activeField($attribute, $model);
                    $append = $generator->appendActiveField($attribute, $model);

                    if ($prepend) {
                        echo "\n\t\t\t".$prepend;
                    }
                    if ($field) {
                        echo "\n\t\t\t<?= ".$field.' ?>';
                    }
                    if ($append) {
                        echo "\n\t\t\t".$append;
                    }
                }
                ?>

            </p>

            <?php
            $label = substr(strrchr($model::className(), '\\'), 1);

            $items = <<<EOS
    [
        'label'   => Yii::t('$generator->modelMessageCategory', '$label'),
        'content' => \$this->blocks['main'],
        'active'  => true,
    ],
    EOS;
            ?>

            <hr/>

            <?= '<?php ' ?>echo $form->errorSummary($model); ?>

            <?= '<?= ' ?>Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> ' .
            ($model->isNewRecord ? <?= $generator->generateString('Create') ?> : <?= $generator->generateString('Save') ?>),
            [
            'id' => 'save-' . $model->formName(),
            'class' => 'btn btn-success'
            ]
            );
            ?>

            <?= '<?php ' ?>ActiveForm::end(); ?>

        </div>

    </div>



</div>
