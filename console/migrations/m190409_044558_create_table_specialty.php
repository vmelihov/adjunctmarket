<?php

use common\src\migration\TableMigration;

/**
 * Class m190409_044558_create_table_specialty
 */
class m190409_044558_create_table_specialty extends TableMigration
{
    /**
     * @inheritDoc
     */
    protected function getTableName(): string
    {
        return 'specialty';
    }

    /**
     * @inheritDoc
     */
    protected function getTableColumns(): array
    {
        return [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'faculty_id' => $this->integer()->notNull(),
        ];
    }

    /**
     * @inheritDoc
     */
    protected function getForeignKeysParams(): array
    {
        return [
            ['specialty_faculty_fk', 'specialty', 'faculty_id', 'faculty', 'id']
        ];
    }

    /**
     * @inheritDoc
     */
    protected function getTableColumnValues(): array
    {
        return [
            ['id' => 1, 'name' => 'Agricultural Economics and Agribusiness', 'faculty_id' => 1],
            ['id' => 2, 'name' => 'Agricultural Extension', 'faculty_id' => 1],
            ['id' => 3, 'name' => 'Animal Science', 'faculty_id' => 1],
            ['id' => 4, 'name' => 'Entomology', 'faculty_id' => 1],
            ['id' => 5, 'name' => 'Environmental Science, Ecology, and Forestry', 'faculty_id' => 1],
            ['id' => 6, 'name' => 'Food Science', 'faculty_id' => 1],
            ['id' => 7, 'name' => 'Horticulture and Landscape Architecture', 'faculty_id' => 1],
            ['id' => 8, 'name' => 'Plant and Soil Science', 'faculty_id' => 1],
            ['id' => 9, 'name' => 'Veterinary Medicine', 'faculty_id' => 1],
            ['id' => 10, 'name' => 'Other Agriculture Faculty', 'faculty_id' => 1],
            ['id' => 11, 'name' => 'Accounting', 'faculty_id' => 2],
            ['id' => 12, 'name' => 'Business Administration', 'faculty_id' => 2],
            ['id' => 13, 'name' => 'Business Law', 'faculty_id' => 2],
            ['id' => 14, 'name' => 'Entrepreneurship', 'faculty_id' => 2],
            ['id' => 15, 'name' => 'Finance', 'faculty_id' => 2],
            ['id' => 16, 'name' => 'Hotel and Restaurant Management', 'faculty_id' => 2],
            ['id' => 17, 'name' => 'Human Resources', 'faculty_id' => 2],
            ['id' => 18, 'name' => 'Information Systems and Technology', 'faculty_id' => 2],
            ['id' => 19, 'name' => 'International Business', 'faculty_id' => 2],
            ['id' => 20, 'name' => 'Management', 'faculty_id' => 2],
            ['id' => 21, 'name' => 'Marketing and Sales', 'faculty_id' => 2],
            ['id' => 22, 'name' => 'Other Business Faculty', 'faculty_id' => 2],
            ['id' => 23, 'name' => 'Broadcast Journalism', 'faculty_id' => 3],
            ['id' => 24, 'name' => 'Film and Video', 'faculty_id' => 3],
            ['id' => 25, 'name' => 'Journalism', 'faculty_id' => 3],
            ['id' => 26, 'name' => 'Media and Communication Studies', 'faculty_id' => 3],
            ['id' => 27, 'name' => 'Public Relations and Advertising', 'faculty_id' => 3],
            ['id' => 28, 'name' => 'Speech', 'faculty_id' => 3],
            ['id' => 29, 'name' => 'Other Communications Faculty', 'faculty_id' => 3],
            ['id' => 30, 'name' => 'Adult and Distance Education', 'faculty_id' => 4],
            ['id' => 31, 'name' => 'Counselor Education', 'faculty_id' => 4],
            ['id' => 32, 'name' => 'Curriculum and Instruction', 'faculty_id' => 4],
            ['id' => 33, 'name' => 'Educational Administration and Leadership ', 'faculty_id' => 4],
            ['id' => 34, 'name' => 'Educational Psychology', 'faculty_id' => 4],
            ['id' => 35, 'name' => 'Higher Education', 'faculty_id' => 4],
            ['id' => 36, 'name' => 'Instructional Technology and Design', 'faculty_id' => 4],
            ['id' => 37, 'name' => 'Reading and Developmental Education', 'faculty_id' => 4],
            ['id' => 38, 'name' => 'School Psychology', 'faculty_id' => 4],
            ['id' => 39, 'name' => 'Special Education', 'faculty_id' => 4],
            ['id' => 40, 'name' => 'Teacher Education', 'faculty_id' => 4],
            ['id' => 41, 'name' => 'Teacher Education - Early Childhood', 'faculty_id' => 4],
            ['id' => 42, 'name' => 'Teacher Education - Elementary', 'faculty_id' => 4],
            ['id' => 43, 'name' => 'Teacher Education - Middle School', 'faculty_id' => 4],
            ['id' => 44, 'name' => 'Teacher Education - Secondary Education', 'faculty_id' => 4],
            ['id' => 45, 'name' => 'Other Education', 'faculty_id' => 4],
            ['id' => 46, 'name' => 'Aerospace Engineering', 'faculty_id' => 5],
            ['id' => 47, 'name' => 'Agricultural Engineering', 'faculty_id' => 5],
            ['id' => 48, 'name' => 'Biological Engineering', 'faculty_id' => 5],
            ['id' => 49, 'name' => 'Chemical Engineering', 'faculty_id' => 5],
            ['id' => 50, 'name' => 'Civil and Environmental Engineering', 'faculty_id' => 5],
            ['id' => 51, 'name' => 'Computer Engineering', 'faculty_id' => 5],
            ['id' => 52, 'name' => 'Electrical Engineering', 'faculty_id' => 5],
            ['id' => 53, 'name' => 'Industrial and Manufacturing Engineering', 'faculty_id' => 5],
            ['id' => 54, 'name' => 'Mechanical Engineering', 'faculty_id' => 5],
            ['id' => 55, 'name' => 'Other Engineering Faculty', 'faculty_id' => 5],
            ['id' => 56, 'name' => 'Architecture', 'faculty_id' => 6],
            ['id' => 57, 'name' => 'Art', 'faculty_id' => 6],
            ['id' => 58, 'name' => 'Art History', 'faculty_id' => 6],
            ['id' => 59, 'name' => 'Digital Arts', 'faculty_id' => 6],
            ['id' => 60, 'name' => 'Fashion and Textile Design', 'faculty_id' => 6],
            ['id' => 61, 'name' => 'Graphic Design', 'faculty_id' => 6],
            ['id' => 62, 'name' => 'Industrial Design', 'faculty_id' => 6],
            ['id' => 63, 'name' => 'Interior Design', 'faculty_id' => 6],
            ['id' => 64, 'name' => 'Music', 'faculty_id' => 6],
            ['id' => 65, 'name' => 'Photography', 'faculty_id' => 6],
            ['id' => 66, 'name' => 'Theatre and Dance', 'faculty_id' => 6],
            ['id' => 67, 'name' => 'Other Fine and Applied Arts Faculty', 'faculty_id' => 6],
            ['id' => 68, 'name' => 'Communication Disorders', 'faculty_id' => 7],
            ['id' => 69, 'name' => 'Health Education and Promotion', 'faculty_id' => 7],
            ['id' => 70, 'name' => 'Health Information Technology', 'faculty_id' => 7],
            ['id' => 71, 'name' => 'Healthcare Administration', 'faculty_id' => 7],
            ['id' => 72, 'name' => 'Nutrition and Dietetics', 'faculty_id' => 7],
            ['id' => 73, 'name' => 'Physical and Occupational Therapy', 'faculty_id' => 7],
            ['id' => 74, 'name' => 'Physical Education and Kinesiology', 'faculty_id' => 7],
            ['id' => 75, 'name' => 'Public and Environmental Health', 'faculty_id' => 7],
            ['id' => 76, 'name' => 'Sports Mgmt, Recreation, and Leisure Studies', 'faculty_id' => 7],
            ['id' => 77, 'name' => 'Other Health Faculty ', 'faculty_id' => 7],
            ['id' => 78, 'name' => 'American Studies', 'faculty_id' => 9],
            ['id' => 79, 'name' => 'Anthropology', 'faculty_id' => 9],
            ['id' => 80, 'name' => 'Criminal Justice', 'faculty_id' => 9],
            ['id' => 81, 'name' => 'Economics', 'faculty_id' => 9],
            ['id' => 82, 'name' => 'English and Literature', 'faculty_id' => 9],
            ['id' => 83, 'name' => 'English as a Second Language', 'faculty_id' => 9],
            ['id' => 84, 'name' => 'Ethnic and Multicultural Studies', 'faculty_id' => 9],
            ['id' => 85, 'name' => 'Foreign Languages and Literatures', 'faculty_id' => 9],
            ['id' => 86, 'name' => 'History', 'faculty_id' => 9],
            ['id' => 87, 'name' => 'Human Development and Family Studies', 'faculty_id' => 9],
            ['id' => 88, 'name' => 'Humanities', 'faculty_id' => 9],
            ['id' => 89, 'name' => 'Linguistics', 'faculty_id' => 9],
            ['id' => 90, 'name' => 'Philosophy', 'faculty_id' => 9],
            ['id' => 91, 'name' => 'Political Science', 'faculty_id' => 9],
            ['id' => 92, 'name' => 'Psychology', 'faculty_id' => 9],
            ['id' => 93, 'name' => 'Public Administration and Policy', 'faculty_id' => 9],
            ['id' => 94, 'name' => 'Religious Studies and Theology', 'faculty_id' => 9],
            ['id' => 95, 'name' => 'Security Studies', 'faculty_id' => 9],
            ['id' => 96, 'name' => 'Social Work', 'faculty_id' => 9],
            ['id' => 97, 'name' => 'Sociology', 'faculty_id' => 9],
            ['id' => 98, 'name' => 'Urban Studies and Planning', 'faculty_id' => 9],
            ['id' => 99, 'name' => 'Women\'s Studies', 'faculty_id' => 9],
            ['id' => 100, 'name' => 'Other Liberal Arts Faculty', 'faculty_id' => 9],
            ['id' => 101, 'name' => 'Dentistry', 'faculty_id' => 10],
            ['id' => 102, 'name' => 'Emergency Medical Services', 'faculty_id' => 10],
            ['id' => 103, 'name' => 'Medical Researcher', 'faculty_id' => 10],
            ['id' => 104, 'name' => 'Nursing', 'faculty_id' => 10],
            ['id' => 105, 'name' => 'Pharmacology', 'faculty_id' => 10],
            ['id' => 106, 'name' => 'Physician Assistants', 'faculty_id' => 10],
            ['id' => 107, 'name' => 'Physicians', 'faculty_id' => 10],
            ['id' => 108, 'name' => 'Radiology', 'faculty_id' => 10],
            ['id' => 109, 'name' => 'Other Medicine', 'faculty_id' => 10],
            ['id' => 110, 'name' => 'Astronomy and Astrophysics', 'faculty_id' => 11],
            ['id' => 111, 'name' => 'Biochemistry and Molecular Biology', 'faculty_id' => 11],
            ['id' => 112, 'name' => 'Biology', 'faculty_id' => 11],
            ['id' => 113, 'name' => 'Chemistry', 'faculty_id' => 11],
            ['id' => 114, 'name' => 'Computer Science', 'faculty_id' => 11],
            ['id' => 115, 'name' => 'Geography', 'faculty_id' => 11],
            ['id' => 116, 'name' => 'Geology, Earth Sciences, and Oceanography', 'faculty_id' => 11],
            ['id' => 117, 'name' => 'Library and Information Science', 'faculty_id' => 11],
            ['id' => 118, 'name' => 'Mathematics', 'faculty_id' => 11],
            ['id' => 119, 'name' => 'Physics', 'faculty_id' => 11],
            ['id' => 120, 'name' => 'Statistics', 'faculty_id' => 11],
            ['id' => 121, 'name' => 'Other Science Faculty', 'faculty_id' => 11],
            ['id' => 122, 'name' => 'Automotive Technology', 'faculty_id' => 12],
            ['id' => 123, 'name' => 'Aviation', 'faculty_id' => 12],
            ['id' => 124, 'name' => 'Construction and Building Trades', 'faculty_id' => 12],
            ['id' => 125, 'name' => 'Cosmetology', 'faculty_id' => 12],
            ['id' => 126, 'name' => 'Culinary Arts', 'faculty_id' => 12],
            ['id' => 127, 'name' => 'Electronics', 'faculty_id' => 12],
            ['id' => 128, 'name' => 'Fire Science', 'faculty_id' => 12],
            ['id' => 129, 'name' => 'Massage Therapy', 'faculty_id' => 12],
            ['id' => 130, 'name' => 'Medical Assistants', 'faculty_id' => 12],
            ['id' => 131, 'name' => 'Medical Billing and Coding', 'faculty_id' => 12],
            ['id' => 132, 'name' => 'Telecommunications', 'faculty_id' => 12],
            ['id' => 133, 'name' => 'Tourism', 'faculty_id' => 12],
            ['id' => 134, 'name' => 'Other Vocational and Technical', 'faculty_id' => 12],
        ];
    }
}
