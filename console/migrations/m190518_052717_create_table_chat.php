<?php

use common\src\migration\TableMigration;

/**
 * Class m190518_052717_create_table_chat
 */
class m190518_052717_create_table_chat extends TableMigration
{
    /**
     * @inheritDoc
     */
    protected function getTableName(): string
    {
        return 'chat';
    }

    /**
     * @inheritDoc
     */
    protected function getTableColumns(): array
    {
        return [
            'id' => $this->primaryKey(),
            'vacancy_id' => $this->integer(),
            'adjunct_user_id' => $this->integer()->notNull(),
            'institution_user_id' => $this->integer()->notNull(),
        ];
    }

    /**
     * @inheritDoc
     */
    protected function getForeignKeysParams(): array
    {
        return [
            ['chat_adjunct_user_fk', 'chat', 'adjunct_user_id', 'user', 'id'],
            ['chat_institution_user_fk', 'chat', 'institution_user_id', 'user', 'id'],
        ];
    }
}
