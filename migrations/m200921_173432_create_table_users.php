<?php

use yii\db\Migration;

use app\models\default\User;

class m200921_173432_create_table_users extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $timestampColumns = require __DIR__ . DIRECTORY_SEPARATOR . '_migration_timestamp_columns.php';

        $this->createTable(
            '{{%users}}',
            array_merge([
                'id' => $this->primaryKey(),
                'username' => $this->string(64)->notNull(),
                'email' => $this->string(64)->notNull(),
                'password_hash' => $this->string(64)->notNull(),

                'auth_key' => $this->string(64),
                'password_reset_token' => $this->string(64),
                'verification_token' => $this->string(64),
                'role' => $this->integer()->notNull()->defaultValue(User::ROLE_USER),
                
                'status' => $this->integer()->notNull()->defaultValue(User::STATUS_INACTIVE),
            ], $timestampColumns),
            $tableOptions
        );

        $this->insert('{{%users}}', [
            'username' => 'admin',
            //12345678
            'password_hash' => '$2y$13$F2g0DJS8xzflDVLQ7Yzsm.51FGx1bDLBYFO9hOoVX1vv9u7PH1VR.',
            'email' => 'admin@gmail.com',
            'status' => User::STATUS_ACTIVE,
            'role' => User::ROLE_ADMIN,

            'access_token' => Yii::$app->security->generateRandomString() . '_' . time(),
        ]);
        $this->insert('{{%users}}', [
            'username' => 'moderator',
            //12345678
            'password_hash' => '$2y$13$F2g0DJS8xzflDVLQ7Yzsm.51FGx1bDLBYFO9hOoVX1vv9u7PH1VR.',
            'email' => 'moderator@gmail.com',
            'status' => User::STATUS_ACTIVE,
            'role' => User::ROLE_MODERATOR,
            'access_token' => Yii::$app->security->generateRandomString() . '_' . time(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%users}}');
    }
}
