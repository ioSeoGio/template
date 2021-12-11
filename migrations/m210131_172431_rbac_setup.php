<?php

use yii\db\Migration;

class m210131_172431_rbac_setup extends Migration
{
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
    
        $adminRule = new \app\rbac\AdminRule(); 
        $moderatorRule = new \app\rbac\ModeratorRule(); 
        $userRule = new \app\rbac\UserRule(); 
        $auth->add($adminRule);
        $auth->add($moderatorRule);
        $auth->add($userRule);

        $admin = $auth->createRole('admin');
        $admin->ruleName = $adminRule->name;
        $auth->add($admin);

        $moderator = $auth->createRole('moderator');
        $moderator->ruleName = $moderatorRule->name;
        $auth->add($moderator);

        $user = $auth->createRole('user');
        $user->ruleName = $userRule->name;
        $auth->add($user);

    }

    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        
        $user = $auth->getRole('user');
        $moderator = $auth->getRole('moderator');
        $admin = $auth->getRole('admin');
        $userRule = $auth->getRule((new \app\rbac\UserRule())->name);
        $moderatorRule = $auth->getRule((new \app\rbac\ModeratorRule())->name);
        $adminRule = $auth->getRule((new \app\rbac\AdminRule())->name);

        $auth->remove($user);
        $auth->remove($moderator);
        $auth->remove($admin);

        $auth->remove($userRule);
        $auth->remove($moderatorRule);
        $auth->remove($adminRule);

        return true;
    }
}
