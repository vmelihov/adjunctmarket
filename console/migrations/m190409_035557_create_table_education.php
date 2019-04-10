<?php

use common\src\migration\TableMigration;

/**
 * Class m190409_035557_create_table_education
 */
class m190409_035557_create_table_education extends TableMigration
{

    /**
     * @inheritDoc
     */
    protected function getTableName(): string
    {
        return 'education';
    }

    /**
     * @inheritDoc
     */
    protected function getTableColumns(): array
    {
        return [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'min_age' => $this->integer(),
        ];
    }

    /**
     * @inheritDoc
     */
    protected function getTableColumnValues(): array
    {
        return [
            ['id' => 15, 'name' => '12th grade - no diploma', 'min_age' => 18],
            ['id' => 16, 'name' => 'Regular high school diploma', 'min_age' => 18],
            ['id' => 17, 'name' => 'GED or alternative credential', 'min_age' => 18],
            ['id' => 18, 'name' => 'Some college, but less than 1 year', 'min_age' => 20],
            ['id' => 19, 'name' => '1 or more years of college credit, no degree', 'min_age' => 20],
            ['id' => 20, 'name' => 'Associate\'s degree', 'min_age' => 20],
            ['id' => 21, 'name' => 'Bachelor\'s degree', 'min_age' => 22],
            ['id' => 22, 'name' => 'Master\'s degree', 'min_age' => 25],
            ['id' => 23, 'name' => 'Professional degree beyond a bachelor\'s degree', 'min_age' => 27],
            ['id' => 24, 'name' => 'Doctorate degree', 'min_age' => 27],
        ];
    }
}
