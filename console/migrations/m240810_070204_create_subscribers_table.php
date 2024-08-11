<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscribers}}`.
 */
class m240810_070204_create_subscribers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscribers}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->bigInteger()->unsigned(),
            'phone' => $this->string(13)->notNull(),
        ]);

        $this->addForeignKey(
            'fk_subscriber_user_author_id',
            '{{%subscribers}}',
            'author_id',
            '{{%authors}}',
            'id',
            'cascade',
            'cascade'
        );

        $this->createIndex(
            'idx_author_id_phone',
            '{{%subscribers}}',
            ['author_id', 'phone'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%subscribers}}');
    }
}
