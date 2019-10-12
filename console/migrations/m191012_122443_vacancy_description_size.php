<?php

use yii\db\Migration;

/**
 * Class m191012_122443_vacancy_decription_size
 */
class m191012_122443_vacancy_description_size extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{vacancy}}', 'description', $this->string(3000));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{vacancy}}', 'description', $this->string(300));
    }
}
