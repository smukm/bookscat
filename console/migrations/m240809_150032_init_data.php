<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m240809_150032_init_data
 */
class m240809_150032_init_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%user}}', [
            'username' => 'user',
            'auth_key' => '',
            'password_hash'=> Yii::$app->security->generatePasswordHash('12345678'),
            'email' => 'user@bookscat.test',
            'status' => User::STATUS_ACTIVE,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%user}}', ['email' => 'user@bookscat.test']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240809_150032_init_data cannot be reverted.\n";

        return false;
    }
    */
}
