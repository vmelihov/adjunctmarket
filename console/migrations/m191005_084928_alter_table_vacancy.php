<?php

use yii\db\Migration;

/**
 * Class m191005_084928_alter_table_vacancy
 */
class m191005_084928_alter_table_vacancy extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{vacancy}}', 'area_id', $this->integer()->null());
        $this->alterColumn('{{vacancy}}', 'education_id', $this->integer()->null());
        $this->alterColumn('{{vacancy}}', 'teach_type_id', $this->integer()->null());
        $this->alterColumn('{{vacancy}}', 'teach_time_id', $this->integer()->null());
        $this->alterColumn('{{vacancy}}', 'teach_period_id', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{vacancy}}', 'area_id', $this->integer());
        $this->alterColumn('{{vacancy}}', 'education_id', $this->integer());
        $this->alterColumn('{{vacancy}}', 'teach_type_id', $this->integer());
        $this->alterColumn('{{vacancy}}', 'teach_time_id', $this->integer());
        $this->alterColumn('{{vacancy}}', 'teach_period_id', $this->integer());
    }
}
