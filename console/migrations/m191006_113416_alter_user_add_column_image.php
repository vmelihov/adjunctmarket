<?php

use yii\db\Migration;

/**
 * Class m191006_113416_alter_user_add_column_image
 */
class m191006_113416_alter_user_add_column_image extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{user}}', 'image', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{user}}', 'image');
    }
}
