<?php

use yii\db\Migration;

/**
 * Class m191114_042524_add_columns_to_adjunct
 */
class m191114_042524_add_columns_to_adjunct extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{adjunct}}', 'phone', $this->string()->null());
        $this->addColumn('{{adjunct}}', 'location_id', $this->integer()->null());
        $this->addColumn('{{adjunct}}', 'linledin', $this->string()->null());
        $this->addColumn('{{adjunct}}', 'facebook', $this->string()->null());
        $this->addColumn('{{adjunct}}', 'whatsapp', $this->string()->null());
        $this->addColumn('{{adjunct}}', 'documents', $this->string()->defaultValue('[]'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{adjunct}}', 'phone');
        $this->dropColumn('{{adjunct}}', 'location_id');
        $this->dropColumn('{{adjunct}}', 'linledin');
        $this->dropColumn('{{adjunct}}', 'facebook');
        $this->dropColumn('{{adjunct}}', 'whatsapp');
        $this->dropColumn('{{adjunct}}', 'documents');
    }
}
