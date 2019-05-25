<?php

use yii\db\Migration;

/**
 * Class m190525_034550_alter_table_vacancy_institution_to_user
 */
class m190525_034550_alter_table_vacancy_institution_to_user extends Migration
{
    public function safeUp()
    {
        $this->dropForeignKey('vacancy_institution_fk', 'vacancy');
        $this->dropColumn('{{vacancy}}', 'institution_id');

        $this->addColumn('{{vacancy}}', 'institution_user_id', $this->integer());
        $this->addForeignKey('vacancy_user_fk', 'vacancy', 'institution_user_id', 'user', 'id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('vacancy_user_fk', 'vacancy');
        $this->dropColumn('{{vacancy}}', 'institution_user_id');

        $this->addColumn('{{vacancy}}', 'institution_id', $this->integer());
        $this->addForeignKey('vacancy_institution_fk', 'institution', 'institution_id', 'institution', 'id');

    }
}
