<?php

use yii\db\Migration;

/**
 * Class m191012_121216_institution_title_dicsr_is_null
 */
class m191012_121216_institution_title_dicsr_is_null extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{institution}}', 'title', $this->string()->null());
        $this->alterColumn('{{institution}}', 'description', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{institution}}', 'title', $this->string());
        $this->alterColumn('{{institution}}', 'description', $this->string());
    }
}
