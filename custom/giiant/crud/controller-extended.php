<?php
/**
 * Customizable controller class.
 */
echo "<?php\n";
?>

namespace <?= \yii\helpers\StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

/**
* This is the class for controller "<?= $controllerClassName ?>".
*/
class <?= $controllerClassName ?> extends <?= (isset($generator->controllerNs) ? '\\'.$generator->controllerNs.'\\' : '') .'base\\'.$controllerClassName."\n" ?>
{
    /**
    * @inheritdoc
    */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => array_merge(parent::access_rules(), [
                    [
                        'allow' => true,
                        'actions' => [],
                        'roles' => [],
                    ],
                ]),
            ],
        ]);
    }


}
