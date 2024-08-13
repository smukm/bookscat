<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%authors}}`.
 */
class m240809_143738_create_authors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
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

        $this->createIndex('idx_authors_lastname', '{{%authors}}', 'lastname');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('{{%authors}}');
    }
}
