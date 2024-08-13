<?php

declare(strict_types=1);

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
    public function safeUp(): void
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
    public function safeDown(): void
    {
        $this->delete('{{%user}}', ['email' => 'user@bookscat.test']);
    }

}
