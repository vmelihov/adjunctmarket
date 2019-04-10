<?php

use common\src\migration\TableMigration;

/**
 * Class m190409_041033_create_table_teaching_period
 */
class m190409_041033_create_table_teaching_period extends TableMigration
{
    /**
     * @inheritDoc
     */
    protected function getTableName(): string
    {
        return 'teaching_period';
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
            ['id' => 1, 'name' => 'Full Semester'],
            ['id' => 2, 'name' => 'Occasional Lecturing'],
            ['id' => 3, 'name' => 'Either of the two'],
        ];
    }
}
