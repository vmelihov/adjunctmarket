<?php

use yii\db\Migration;

/**
 * Class m190427_054147_add_column_locations_to_institution
 */
class m190427_054147_add_column_location_id_to_institution extends Migration
{
    public function up()
    {
        $this->addColumn('{{institution}}', 'location_id', $this->integer());
        $this->addForeignKey('institution_location_id_fk', 'institution', 'location_id', 'area', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('institution_location_id_fk', 'institution');
        $this->dropColumn('{{institution}}', 'location_id');
    }
}
