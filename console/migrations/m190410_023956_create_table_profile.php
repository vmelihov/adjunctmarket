<?php

use common\src\migration\TableMigration;

/**
 * Class m190410_023956_create_table_profile
 */
class m190410_023956_create_table_profile extends TableMigration
{
    /**
     * @inheritDoc
     */
    protected function getTableName(): string
    {
        return 'profile';
    }

    /**
     * @inheritDoc
     */
    protected function getTableColumns(): array
    {
        return [
            'id' => $this->primaryKey(),
            'title' => $this->string(200)->notNull(),
            'description' => $this->string(200)->notNull(),
            'age' => $this->smallInteger()->defaultValue(null),
            'sex' => $this->smallInteger()->defaultValue(null),
            'teaching_experience_type_id' => $this->integer()->defaultValue(null),
            'education_id' => $this->integer()->defaultValue(null),
            'teach_type_id' => $this->integer()->defaultValue(null),
            'teach_locations' => $this->string()->defaultValue(null),
            'teach_time_id' => $this->integer()->defaultValue(null),
            'teach_period_id' => $this->integer()->defaultValue(null),
            'faculties' => $this->string()->defaultValue(null),
        ];
    }

    /**
     * @inheritDoc
     */
    protected function getForeignKeysParams(): array
    {
        return [
            ['profile_teaching_type_fk', 'profile', 'teaching_experience_type_id', 'teaching_type', 'id'],
            ['profile_education_fk', 'profile', 'education_id', 'education', 'id'],
            ['profile_teach_type_fk', 'profile', 'teach_type_id', 'teaching_type', 'id'],
            ['profile_teach_time_fk', 'profile', 'teach_time_id', 'teaching_time', 'id'],
            ['profile_teach_period_fk', 'profile', 'teach_period_id', 'teaching_period', 'id'],
        ];
    }

}
