<?php

use common\src\migration\TableMigration;

/**
 * Class m190409_025941_create_table_state
 */
class m190409_025941_create_table_state extends TableMigration
{
    protected function getTableName(): string
    {
        return 'state';
    }

    /**
     * @return array
     */
    protected function getTableColumns(): array
    {
        return [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
        ];
    }

    /**
     * @return array
     */
    protected function getTableColumnValues(): array
    {
        return [
            ['id' => 1, 'name' => 'Alabama'],
            ['id' => 2, 'name' => 'Alaska'],
            ['id' => 3, 'name' => 'Arizona'],
            ['id' => 4, 'name' => 'Arkansas'],
            ['id' => 5, 'name' => 'California'],
            ['id' => 6, 'name' => 'Colorado'],
            ['id' => 7, 'name' => 'Connecticut'],
            ['id' => 8, 'name' => 'Delaware'],
            ['id' => 9, 'name' => 'District of Columbia'],
            ['id' => 10, 'name' => 'Florida'],
            ['id' => 11, 'name' => 'Georgia'],
            ['id' => 12, 'name' => 'Hawaii'],
            ['id' => 13, 'name' => 'Idaho'],
            ['id' => 14, 'name' => 'Illinois'],
            ['id' => 15, 'name' => 'Indiana'],
            ['id' => 16, 'name' => 'Iowa'],
            ['id' => 17, 'name' => 'Kansas'],
            ['id' => 18, 'name' => 'Kentucky'],
            ['id' => 19, 'name' => 'Louisiana'],
            ['id' => 20, 'name' => 'Maine'],
            ['id' => 21, 'name' => 'Maryland'],
            ['id' => 22, 'name' => 'Massachusetts'],
            ['id' => 23, 'name' => 'Michigan'],
            ['id' => 24, 'name' => 'Minnesota'],
            ['id' => 25, 'name' => 'Mississippi'],
            ['id' => 26, 'name' => 'Missouri'],
            ['id' => 27, 'name' => 'Montana'],
            ['id' => 28, 'name' => 'Nebraska'],
            ['id' => 29, 'name' => 'Nevada'],
            ['id' => 30, 'name' => 'New Hampshire'],
            ['id' => 31, 'name' => 'New Jersey'],
            ['id' => 32, 'name' => 'New Mexico'],
            ['id' => 33, 'name' => 'New York'],
            ['id' => 34, 'name' => 'North Carolina'],
            ['id' => 35, 'name' => 'North Dakota'],
            ['id' => 36, 'name' => 'Ohio'],
            ['id' => 37, 'name' => 'Oklahoma'],
            ['id' => 38, 'name' => 'Oregon'],
            ['id' => 39, 'name' => 'Pennsylvania'],
            ['id' => 40, 'name' => 'Rhode Island'],
            ['id' => 41, 'name' => 'South Carolina'],
            ['id' => 42, 'name' => 'South Dakota'],
            ['id' => 43, 'name' => 'Tennessee'],
            ['id' => 44, 'name' => 'Texas'],
            ['id' => 45, 'name' => 'Utah'],
            ['id' => 46, 'name' => 'Vermont'],
            ['id' => 47, 'name' => 'Virginia'],
            ['id' => 48, 'name' => 'Washington'],
            ['id' => 49, 'name' => 'West Virginia'],
            ['id' => 50, 'name' => 'Wisconsin'],
            ['id' => 51, 'name' => 'Wyoming'],
            ['id' => 52, 'name' => 'Puerto Rico'],
        ];
    }
}
