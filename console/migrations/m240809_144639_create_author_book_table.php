<?php

declare(strict_types=1);

use yii\db\Migration;


class m240809_144639_create_author_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%author_book}}', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'author_id' => $this->bigInteger()->unsigned()->notNull(),
            'book_id' => $this->bigInteger()->unsigned()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_author_book_author_id',
            '{{%author_book}}',
            'author_id',
            '{{%authors}}',
            'id',
            'cascade',
            'cascade'
        );

        $this->addForeignKey(
            'fk_author_book_book_id',
            '{{%author_book}}',
            'book_id',
            '{{%books}}',
            'id',
            'cascade',
            'cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('{{%author_book}}');
    }
}
