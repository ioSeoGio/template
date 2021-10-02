<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/*
 * @var yii\web\View $this
 * @var schmunk42\giiant\generators\crud\Generator $generator
 */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

/** @var \yii\db\ActiveRecord $model */
$model = new $generator->modelClass();
$model->setScenario('crud');

$modelName = Inflector::camel2words(Inflector::pluralize(StringHelper::basename($model::className())));

$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    /** @var \yii\db\ActiveRecord $model */
    $model = new $generator->modelClass();
    $safeAttributes = $model->safeAttributes();
    if (empty($safeAttributes)) {
        $safeAttributes = $model->getTableSchema()->columnNames;
    }
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\helpers\Url;
use <?= $generator->indexWidgetType === 'grid' ? $generator->indexGridClass : 'yii\\widgets\\ListView' ?>;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
<?php if ($generator->searchModelClass !== ''): ?>
* @var <?= ltrim($generator->searchModelClass, '\\') ?> $searchModel
<?php endif; ?>
*/

$this->title = Yii::t(<?= "'{$generator->modelMessageCategory}', '{$modelName}'" ?>);
$this->params['breadcrumbs'][] = $this->title;

// TODO: deal with permissions generation (seog)
<?php if($generator->accessFilter): ?>
/**
* create action column template depending acces rights
*/
$actionColumnTemplates = [];

if (\Yii::$app->user->can('<?=$permisions['view']['name']?>', ['route' => true])) {
    $actionColumnTemplates[] = '{view}';
}

if (\Yii::$app->user->can('<?=$permisions['update']['name']?>', ['route' => true])) {
    $actionColumnTemplates[] = '{update}';
}

if (\Yii::$app->user->can('<?=$permisions['delete']['name']?>', ['route' => true])) {
    $actionColumnTemplates[] = '{delete}';
}
<?php endif; ?>

if (isset($actionColumnTemplates)) {
    $actionColumnTemplateString = implode(' ', $actionColumnTemplates);
} else {
    Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . <?= $generator->generateString('New') ?>, ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';
<?= '?>'; ?>


<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass), '-', true) ?>-index">

    <?= "<?".($generator->indexWidgetType === 'grid' ? '//' : '') ?>
<?php if ($generator->searchModelClass !== ''): ?>
= $this->render('_search', ['model' =>$searchModel]); ?>
<?php endif; ?>

<?php if ($generator->indexWidgetType === 'grid'): ?>
    <h1>
        <?= "<?= Yii::t('{$generator->modelMessageCategory}', '{$modelName}') ?>\n" ?>
        <small>
            List
        </small>
    </h1>

    <div class="clearfix crud-navigation">
<?php if($generator->accessFilter) { 
    echo "\t\t<?php ";
?>
if(\Yii::$app->user->can('<?=$permisions['create']['name']?>', ['route' => true])): ?>
            <div class="pull-left">
                <?= '<?= ' ?>Html::a(
                    <?= $generator->generateString('New') ?>, 
                    ['create'], 
                    ['class' => 'btn btn-success']) 
                ?>
            </div>
<?php
	echo "\t\t<?php endif; ?>\n";
} ?>
    </div>

    <div class="table-responsive">
        <?= '<?= ' ?>GridView::widget([
            'dataProvider' => $dataProvider,
            'pager' => [
                'class' => yii\widgets\LinkPager::className(),
                'firstPageLabel' => <?= $generator->generateString('First') ?>,
                'lastPageLabel' => <?= $generator->generateString('Last').",\n" ?>
            ],
<?php if ($generator->searchModelClass !== ''): ?>
            'filterModel' => $searchModel,
<?php endif; ?>
            'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
            'headerRowOptions' => ['class' => 'x'],
            'columns' => [
            <?php
            $actionButtonColumn = <<<PHP
        [
                        'class' => '{$generator->actionButtonClass}',
                        'template' => \$actionColumnTemplateString,
                        'buttons' => [
                            // 'view' => function (\$url, \$model, \$key) {
                            //     \$options = [
                            //         'title' => Yii::t('{$generator->messageCategory}', 'View'),
                            //         'aria-label' => Yii::t('{$generator->messageCategory}', 'View'),
                            //         'data-pjax' => '0',
                            //     ];
                            //     return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', \$url, \$options);
                            // }
                        ],
                        'urlCreator' => function(\$action, \$model, \$key, \$index) {
                            // using the column name as key, not mapping to 'id' like the standard generator
                            \$params = is_array(\$key) ? \$key : [\$model->primaryKey()[0] => (string) \$key];
                            \$params[0] = \Yii::\$app->controller->id ? \Yii::\$app->controller->id . '/' . \$action : \$action;
                            return Url::toRoute(\$params);
                        },
                        'contentOptions' => ['nowrap' => 'nowrap']
                    ],
    PHP;

            $count = 0;
            // action buttons first
            if ($generator->actionButtonColumnPosition != 'right') {
                echo $actionButtonColumn;
                echo "\n"; // code-formatting
            }

            foreach ($safeAttributes as $attribute) {
                $format = trim($generator->columnFormat($attribute, $model));
                if ($format == false) {
                    continue;
                }
                if (++$count < $generator->gridMaxColumns) {
                    echo "\t\t\t\t" . str_replace("\n", "\n\t\t\t", $format) . ",\n";
                } else {
                    echo "\t\t\t\t/*" . str_replace("\n", "\n\t\t\t", $format) . ",*/\n";
                }
            }

            ?>
            <?php if ($generator->actionButtonColumnPosition == 'right') {
                echo $actionButtonColumn;
                echo "\n"; // code-formatting
            } ?>
]
        ]); ?>
    </div>

</div>


<?php else: ?>

    <?= '<?= ' ?> ListView::widget([
    'dataProvider' => $dataProvider,
    'itemOptions' => ['class' => 'item'],
    'itemView' => function ($model, $key, $index, $widget) {
    return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
    },
    ]); ?>

<?php endif; ?>

