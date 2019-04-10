<?php

use common\src\migration\TableMigration;

/**
 * Class m190409_041219_create_table_teaching_time
 */
class m190409_041219_create_table_teaching_time extends TableMigration
{
    /**
     * @inheritDoc
     */
    protected function getTableName(): string
    {
        return 'teaching_time';
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
            ['id' => 1, 'name' => 'During the day'],
            ['id' => 2, 'name' => 'Evenings only'],
            ['id' => 3, 'name' => 'Weekends'],
            ['id' => 4, 'name' => 'Evenings and Weeke'],
            ['id' => 5, 'name' => 'Either of the three'],
        ];
    }
}
