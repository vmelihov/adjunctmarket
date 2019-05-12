<?php

use yii\db\Migration;

/**
 * Class m190512_065718_alter_column_institution_id_to_university_id
 */
class m190512_065718_alter_column_institution_id_to_university_id extends Migration
{
    public function safeUp()
    {
        $this->dropForeignKey('institution_location_id_fk', 'institution');
        $this->dropColumn('{{institution}}', 'location_id');

        $this->addColumn('{{institution}}', 'university_id', $this->integer());
        $this->addForeignKey('institution_university_fk', 'institution', 'university_id', 'university', 'id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('institution_university_fk', 'institution');
        $this->dropColumn('{{institution}}', 'university_id');

        $this->addColumn('{{institution}}', 'location_id', $this->integer());
        $this->addForeignKey('institution_location_id_fk', 'institution', 'location_id', 'area', 'id');

    }
}
