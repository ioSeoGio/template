<?php
namespace app\rbac;

use yii\rbac\Rule;
use app\models\default\User;

class AdminRule extends Rule
{
    public $name = 'isAdmin';

    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated width.
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        $user = User::findIdentity($user);

        if (isset($user)) {
            return $user->role >= User::ROLE_ADMIN;
        }
        return false;
    }
}