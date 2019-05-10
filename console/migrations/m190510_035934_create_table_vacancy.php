<?php

use common\src\migration\TableMigration;

/**
 * Class m190510_035934_create_table_vacancy
 */
class m190510_035934_create_table_vacancy extends TableMigration
{
    /**
     * @inheritDoc
     */
    protected function getTableName(): string
    {
        return 'vacancy';
    }

    /**
     * @inheritDoc
     */
    protected function getTableColumns(): array
    {
        return [
            'id' => $this->primaryKey(),
            'institution_id' => $this->integer()->unique()->notNull(),
            'title' => $this->string(200)->notNull(),
            'description' => $this->string(200)->notNull(),
            'faculty_id' => $this->integer()->notNull(),
//            'speciality_id' => $this->integer()->notNull(),
            'area_id' => $this->integer()->notNull(),
            'education_id' => $this->integer()->notNull(),
            'teach_type_id' => $this->integer()->notNull(),
            'teach_time_id' => $this->integer()->notNull(),
            'teach_period_id' => $this->integer()->notNull(),
            'deleted' => $this->smallInteger()->defaultValue(0),
        ];
    }

    /**
     * @inheritDoc
     */
    protected function getForeignKeysParams(): array
    {
        return [
            ['vacancy_institution_fk', 'vacancy', 'institution_id', 'institution', 'id'],
            ['vacancy_faculty_fk', 'vacancy', 'faculty_id', 'faculty', 'id'],
//            ['vacancy_speciality_fk', 'vacancy', 'speciality_id', 'speciality', 'id'],
            ['vacancy_location_fk', 'vacancy', 'area_id', 'area', 'id'],
            ['vacancy_education_fk', 'vacancy', 'education_id', 'education', 'id'],
            ['vacancy_teach_type_fk', 'vacancy', 'teach_type_id', 'teaching_type', 'id'],
            ['vacancy_teach_time_fk', 'vacancy', 'teach_time_id', 'teaching_time', 'id'],
            ['vacancy_teach_period_fk', 'vacancy', 'teach_period_id', 'teaching_period', 'id'],
        ];
    }
}
