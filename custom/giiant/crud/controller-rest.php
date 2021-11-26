<?php
/**
 * Customizable controller class.
 */
use yii\helpers\StringHelper;

$modelBasename = StringHelper::baseName($generator->modelClass);

echo "<?php\n";
?>

namespace <?= $generator->controllerNs ?>\api;

/**
* This is the class for REST controller "<?= $controllerClassName ?>".
*/
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;

use <?= $generator->modelClass ?>;

class <?= $controllerClassName ?> extends \app\custom\BaseApiController
{
    public $modelClass = <?= $modelBasename ?>::class;
<?php if ($generator->accessFilter): ?>

    /**
    * @inheritdoc
    */
    protected function accessRules()
    {
        return [
            'class' => \yii\filters\AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'matchCallback' => function ($rule, $action) {
                        $permissionName = $this->module->id . '_' . \yii\helpers\StringHelper::basename($this->id) . '_' . $action->id;
                        
                        return \Yii::$app->user->can($permissionName, ['route' => true]);
                    },
                ],
                [
                    'allow' => true,
                    'matchCallback' => function ($rule, $action) {
                        $permissionName = $this->module->id . '_' . \yii\helpers\StringHelper::basename($this->id);
                        $permissionName = \yii\helpers\Inflector::camelize($permissionName) . 'Full';
                        var_dump($permissionName);die;
                        
                        return \Yii::$app->user->can($permissionName, ['route' => true]);
                    },
                ],
            ]
        ];
    }
<?php endif; ?>

    /**
    * @inheritdoc
    */
    protected function getAuthExceptActions()
    {
        return array_merge(parent::getAuthExceptActions(), [
        ]);
    }

    /**
    * @inheritdoc
    */
    protected function getAuthOnlyActions()
    {
        return array_merge(parent::getAuthOnlyActions(), [
            'create',
            'update',
            'delete',
        ]);
    }


    /**
     * Creates new $this->modelClass
     *
     * @param id int
     * @param 
     *
     * @throws \yii\web\UnprocessableEntityHttpException (HTTP 422) When model not saved
     *
     * @return $this->modelClass
     */
    public function actionCreate()
    {
        $model = new $this->modelClass();
        $attributes = Yii::$app->getRequest()->getBodyParams();

        return $this->updateModel($model, $attributes, 201);
    }

    /**
     * Updates $this->modelClass
     *
     * @param id int
     * @param 
     *
     * @throws \yii\web\UnprocessableEntityHttpException (HTTP 422) When model not saved
     *
     * @return $this->modelClass
     */
    public function actionUpdate(int $id)
    {
        $model = $this->modelClass::findModel($id);
        $attributes = Yii::$app->getRequest()->getBodyParams();

        return $this->updateModel($model, $attributes, 201);
    }

    /**
     * Deletes the $this->modelClass by id
     *
     * @param $id int
     *
     * @throws \yii\web\BadRequestException When model deleting failed
     * @throws \yii\web\NotFoundHttpException When model not found
     *
     * @return bool
     */
    public function actionDelete(int $id)
    {
        if ($model = $this->modelClass::findOne($id)) {
            if (!$model->delete()) {
                throw new \yii\web\BadRequestException();
            }
            return true;
        }

        throw new \yii\web\NotFoundHttpException();
    }

}
