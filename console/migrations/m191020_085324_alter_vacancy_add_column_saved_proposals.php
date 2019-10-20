<?php

use yii\db\Migration;

/**
 * Class m191020_085324_alter_vacancy_add_column_saved_proposals
 */
class m191020_085324_alter_vacancy_add_column_saved_proposals extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{vacancy}}', 'saved_proposals', $this->string()->defaultValue('[]'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{vacancy}}', 'saved_proposals');
    }
}
