<?php

use common\src\migration\TableMigration;

/**
 * Class m190418_043237_create_table_institution
 */
class m190418_043237_create_table_institution extends TableMigration
{
    /**
     * @inheritDoc
     */
    protected function getTableName(): string
    {
        return 'institution';
    }

    /**
     * @inheritDoc
     */
    protected function getTableColumns(): array
    {
        return [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string(200)->notNull(),
            'description' => $this->string(200)->notNull(),
        ];
    }

    /**
     * @inheritDoc
     */
    protected function getForeignKeysParams(): array
    {
        return [
            ['institution_user_fk', 'institution', 'user_id', 'user', 'id'],];
    }
}
