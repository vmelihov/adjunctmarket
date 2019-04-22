<?php

use yii\db\Migration;

/**
 * Handles adding first_name_last_name to table `{{%user}}`.
 */
class m190411_030814_add_first_name_last_name_column_to_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{user}}', 'first_name', $this->string()->defaultValue(null));
        $this->addColumn('{{user}}', 'last_name', $this->string()->defaultValue(null));
    }

    public function down()
    {
        $this->dropColumn('{{user}}', 'first_name');
        $this->dropColumn('{{user}}', 'last_name');
    }
}
