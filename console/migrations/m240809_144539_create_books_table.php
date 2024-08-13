<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books}}`.
 */
class m240809_144539_create_books_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%books}}', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'title' => $this->string(255)->notNull(),
            'description'=> $this->text()->null(),
            'release_year' => $this->smallInteger()->unsigned()->notNull(),
            'isbn' => $this->string(17)->notNull(),
            'photo' => $this->string(255)->null(),
        ]);

        $this->createIndex(
            'idx_books_isbn',
            '{{%books}}',
            'isbn',
            true
        );

        $this->createIndex(
            'idx_books_release_year',
            '{{%books}}',
            'release_year'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('{{%books}}');
    }
}
