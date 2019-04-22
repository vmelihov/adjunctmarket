<?php

use yii\db\Migration;

/**
 * Class m190415_030311_drop_column_username_from_user
 */
class m190415_030311_drop_column_username_from_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{user}}', 'username');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{user}}', 'username', $this->smallInteger());
    }
}
