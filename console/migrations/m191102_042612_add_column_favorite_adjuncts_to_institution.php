<?php

use yii\db\Migration;

/**
 * Class m191102_042612_add_column_favorite_adjuncts_to_institution
 */
class m191102_042612_add_column_favorite_adjuncts_to_institution extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{institution}}', 'favorite_adjuncts', $this->string()->defaultValue('[]'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{institution}}', 'favorite_adjuncts');
    }
}
