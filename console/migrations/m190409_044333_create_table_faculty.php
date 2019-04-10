<?php

use common\src\migration\TableMigration;

/**
 * Class m190409_044333_create_table_faculty
 */
class m190409_044333_create_table_faculty extends TableMigration
{
    /**
     * @inheritDoc
     */
    protected function getTableName(): string
    {
        return 'faculty';
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
            ['id' => 1, 'name' => 'Agriculture'],
            ['id' => 2, 'name' => 'Business'],
            ['id' => 3, 'name' => 'Communications'],
            ['id' => 4, 'name' => 'Education'],
            ['id' => 5, 'name' => 'Engineering'],
            ['id' => 6, 'name' => 'Fine and Applied Arts'],
            ['id' => 7, 'name' => 'Health'],
            ['id' => 8, 'name' => 'Law and Legal Studies'],
            ['id' => 9, 'name' => 'Liberal Arts'],
            ['id' => 10, 'name' => 'Medicine'],
            ['id' => 11, 'name' => 'Science'],
            ['id' => 12, 'name' => 'Vocational and Technical'],
        ];
    }
}
