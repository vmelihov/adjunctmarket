<?php

use common\src\migration\TableMigration;

/**
 * Class m190418_042627_create_table_adjunct
 */
class m190418_042627_create_table_adjunct extends TableMigration
{
    /**
     * @inheritDoc
     */
    protected function getTableName(): string
    {
        return 'adjunct';
    }

    /**
     * @inheritDoc
     */
    protected function getTableColumns(): array
    {
        return [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->unique()->notNull(),
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
            'specialities' => $this->string()->defaultValue(null),
        ];
    }

    /**
     * @inheritDoc
     */
    protected function getForeignKeysParams(): array
    {
        return [
            ['adjunct_user_fk', 'adjunct', 'user_id', 'user', 'id'],
            ['adjunct_education_fk', 'adjunct', 'education_id', 'education', 'id'],
            ['adjunct_teaching_exp_type_fk', 'adjunct', 'teaching_experience_type_id', 'teaching_type', 'id'],
            ['adjunct_teach_type_fk', 'adjunct', 'teach_type_id', 'teaching_type', 'id'],
            ['adjunct_teach_time_fk', 'adjunct', 'teach_time_id', 'teaching_time', 'id'],
            ['adjunct_teach_period_fk', 'adjunct', 'teach_period_id', 'teaching_period', 'id'],
        ];
    }
}
