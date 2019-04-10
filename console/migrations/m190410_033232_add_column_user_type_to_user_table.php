<?php

use yii\db\Migration;

/**
 * Class m190410_033232_add_column_user_type_to_user_table
 */
class m190410_033232_add_column_user_type_to_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{user}}', 'user_type', $this->smallInteger());
    }

    public function down()
    {
        $this->dropColumn('{{user}}', 'user_type');
    }
}
