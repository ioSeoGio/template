<?php

use yii\db\Migration;

class m210131_172431_rbac_setup extends Migration
{
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
    
        $adminRule = new \app\rbac\AdminRule(); 
        $userRule = new \app\rbac\UserRule(); 
        $auth->add($adminRule);
        $auth->add($userRule);

        $user = $auth->createRole('user');
        $user->ruleName = $userRule->name;
        $auth->add($user);

        $admin = $auth->createRole('admin');
        $admin->ruleName = $adminRule->name;
        $auth->add($admin);

    }

    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        
        $admin = $auth->getRole('admin');
        $user = $auth->getRole('user');
        $adminRule = $auth->getRule((new \app\rbac\AdminRule())->name);
        $userRule = $auth->getRule((new \app\rbac\UserRule())->name);

        $auth->removeChild($admin, $user);

        $auth->remove($user);
        $auth->remove($admin);

        $auth->remove($adminRule);
        $auth->remove($userRule);

        return true;
    }
}
