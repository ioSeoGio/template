<?php
/**
 * Customizable controller class.
 */
echo "<?php\n";
?>

namespace <?= $generator->controllerNs ?>\api;

/**
* This is the class for REST controller "<?= $controllerClassName ?>".
*/
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;

class <?= $controllerClassName ?> extends \yii\rest\ActiveController
{
    public $modelClass = '<?= $generator->modelClass ?>';
<?php if ($generator->accessFilter): ?>

    /**
    * @inheritdoc
    */
    public function behaviors()
    {
        $behaviours = array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $permissionName = $this->module->id . '_' . $this->id . '_' . $action->id;
                            
                            return \Yii::$app->user->can($permissionName, ['route' => true]);
                        },
                    ]
                ]
            ]
        ]);

        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
        ];
        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);
        
        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];
        
        // re-add authentication filter
        $behaviors['authenticator'] = $auth;
        
        $behaviors['authenticator']['only'] = [
        ];
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = [
            'options',
        ];

        return $behaviors;
        
    }
<?php endif; ?>


    public function actions()
    {
        $actions = parent::actions();

        unset($actions['index']);
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);

        return $actions;
    }

}
