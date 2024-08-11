<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%authors}}`.
 */
class m240809_143738_create_authors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%authors}}', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'firstname' => $this->string(255)
                ->notNull(),
            'middlename' => $this->string(255)
                ->null(),
            'lastname' => $this->string(255)
                ->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%authors}}');
    }
}
