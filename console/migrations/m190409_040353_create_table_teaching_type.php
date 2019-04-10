<?php

use common\src\migration\TableMigration;

/**
 * Class m190409_040353_create_table_teaching_type
 */
class m190409_040353_create_table_teaching_type extends TableMigration
{
    /**
     * @inheritDoc
     */
    protected function getTableName(): string
    {
        return 'teaching_type';
    }

    /**
     * @inheritDoc
     */
    protected function getTableColumns(): array
    {
        return [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ];
    }

    /**
     * @inheritDoc
     */
    protected function getTableColumnValues(): array
    {
        return [
            ['id' => 1, 'name' => 'Online'],
            ['id' => 2, 'name' => 'In person'],
        ];
    }
}
