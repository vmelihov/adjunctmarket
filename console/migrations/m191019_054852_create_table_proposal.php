<?php

use common\src\migration\TableMigration;

/**
 * Class m191019_054852_create_table_proposal
 */
class m191019_054852_create_table_proposal extends TableMigration
{
    /**
     * @inheritDoc
     */
    protected function getTableName(): string
    {
        return 'proposal';
    }

    /**
     * @inheritDoc
     */
    protected function getTableColumns(): array
    {
        return [
            'id' => $this->primaryKey(),
            'vacancy_id' => $this->integer()->notNull(),
            'adjunct_id' => $this->integer()->notNull(),
            'letter' => $this->string(4000),
            'attaches' => $this->string(400),
            'state' => $this->tinyInteger(1)->notNull()->defaultValue(1),
            'created' => $this->integer()->notNull(),
            'updated' => $this->integer()->notNull(),
        ];
    }

    /**
     * @inheritDoc
     */
    protected function getForeignKeysParams(): array
    {
        return [
            ['proposal_adjunct_fk', 'proposal', 'adjunct_id', 'user', 'id'],
            ['proposal_vacancy_fk', 'proposal', 'vacancy_id', 'vacancy', 'id'],
        ];
    }
}
