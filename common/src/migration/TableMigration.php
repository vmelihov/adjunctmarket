<?php

namespace common\src\migration;

use yii\db\Exception;
use yii\db\Migration;

abstract class TableMigration extends Migration
{
    /**
     * @inheritDoc
     */
    public function safeUp()
    {
        $tableName = $this->getTableName();
        $tableColumns = $this->getTableColumns();

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%' . $tableName . '}}', $tableColumns, $tableOptions);


        $foreignKeys = $this->getForeignKeysParams();
        if ($foreignKeys) {
            foreach ($foreignKeys as $foreignKeyParams) {
                $this->addForeignKey(...$foreignKeyParams);
            }
        }

        $columnValues = $this->getTableColumnValues();
        if ($columnValues) {
            foreach ($columnValues as $columnValue) {
                $this->insert($tableName, $columnValue);
            }
        }
    }

    /**
     * @return bool|void
     * @throws Exception
     */
    public function down(): void
    {
        $tableName = $this->getTableName();

        if (!$tableName) {
            throw new Exception('Не указано имя таблицы');
        }

        $foreignKeys = $this->getForeignKeysParams();
        if ($foreignKeys) {
            foreach ($foreignKeys as $foreignKeyParams) {
                $this->dropForeignKey($foreignKeyParams[0], $tableName);
            }
        }

        $this->dropTable('{{%' . $tableName . '}}');
    }

    /**
     * @return string $name
     */
    abstract protected function getTableName(): string;

    /**
     * @return array $columns
     */
    abstract protected function getTableColumns(): array;

    /**
     * @return array
     */
    protected function getForeignKeysParams(): array
    {
        return [];
    }

    /**
     * @return array $columns the column data (name => value) to be inserted into the table.
     */
    protected function getTableColumnValues(): array
    {
        return [];
    }
}