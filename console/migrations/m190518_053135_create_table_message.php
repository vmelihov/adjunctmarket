<?php

use common\src\migration\TableMigration;

/**
 * Class m190518_053135_create_table_message
 */
class m190518_053135_create_table_message extends TableMigration
{
    /**
     * @inheritDoc
     */
    protected function getTableName(): string
    {
        return 'message';
    }

    /**
     * @inheritDoc
     */
    protected function getTableColumns(): array
    {
        return [
            'id' => $this->primaryKey(),
            'chat_id' => $this->integer()->notNull(),
            'author_user_id' => $this->integer()->notNull(),
            'message' => $this->string()->notNull(),
            'created' => $this->integer(11)->notNull(),
            'updated' => $this->integer(11),
            'read' => $this->tinyInteger(1)->defaultValue(0),
        ];
    }

    /**
     * @inheritDoc
     */
    protected function getForeignKeysParams(): array
    {
        return [
            ['message_chat_fk', 'message', 'chat_id', 'chat', 'id'],
            ['message_author_user_fk', 'message', 'author_user_id', 'user', 'id'],
        ];
    }
}
