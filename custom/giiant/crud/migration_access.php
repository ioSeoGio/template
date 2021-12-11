<?php
use yii\helpers\Inflector;
/**
 * Migration for controller access
 */
echo "<?php\n";
?>

use yii\db\Migration;

class <?=$generator->migrationClass?> extends Migration
{
    /**
     * @var array controller all actions
     */
    public $permisions = <?=$generator->var_export54($accessDefinitions['permisions'],'    ')?>;
    
    /**
     * @var array roles and maping to actions/permisions
     */
    public $roles = <?=$generator->var_export54($accessDefinitions['roles'],'    ')?>;
    
    public function up()
    {
        $permisions = [];
        $auth = \Yii::$app->authManager;

        /**
         * create permisions for each controller action
         */
        foreach ($this->permisions as $action => $permission) {
            $permisions[$action] = $auth->createPermission($permission['name']);
            $permisions[$action]->description = $permission['description'];
            $auth->add($permisions[$action]);
        }


        $admin = $auth->getRole('admin');
        $moderator = $auth->getRole('moderator');
        /**
         *  create roles
         */
        foreach ($this->roles as $roleName => $actions) {
            $role = $auth->createRole($roleName);
            $auth->add($role);

            /**
             * to role assign permissions
             */
            foreach ($actions as $action) {
                $auth->addChild($role, $permisions[$action]);
            }

            /**
             * each role assign to admin's role
             */
            $auth->addChild($admin, $role);

            /**
             * each role except UserFull & UserEdit (only UserView)
             */
<?php if (array_key_exists('AppUserFull', $accessDefinitions['roles'])): ?>
            if ($roleName === 'AppUserView') {
                $auth->addChild($moderator, $role);
            }
<?php else: ?>
            $auth->addChild($moderator, $role);
<?php endif; ?>
        }
    }

    public function down() {
        $auth = Yii::$app->authManager;

        foreach ($this->roles as $roleName => $actions) {
            $role = $auth->getRole($roleName);
            $auth->remove($role);
        }

        foreach ($this->permisions as $permission) {
            $authItem = $auth->getPermission($permission['name']);
            $auth->remove($authItem);
        }
    }
}
