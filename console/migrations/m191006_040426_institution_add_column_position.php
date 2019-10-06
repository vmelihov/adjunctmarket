<?php

use yii\db\Migration;

/**
 * Class m191006_040426_institution_add_column_position
 */
class m191006_040426_institution_add_column_position extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{institution}}', 'position', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{institution}}', 'position');
    }
}
