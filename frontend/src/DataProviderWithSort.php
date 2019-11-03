<?php

namespace frontend\src;

use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\db\QueryInterface;

class DataProviderWithSort extends ActiveDataProvider
{
    /** @var callable|null */
    protected $sortCallback;

    /**
     * @return array|void
     * @throws InvalidConfigException
     */
    protected function prepareModels()
    {
        if (!$this->query instanceof QueryInterface) {
            throw new InvalidConfigException('The "query" property must be an instance of a class that implements the QueryInterface e.g. yii\db\Query or its subclasses.');
        }

        $query = clone $this->query;
        if (($pagination = $this->getPagination()) !== false) {
            $pagination->totalCount = $this->getTotalCount();
            if ($pagination->totalCount === 0) {
                return [];
            }
        }

        if (($sort = $this->getSort()) !== false) {
            $query->addOrderBy($sort->getOrders());
        }

        $models = $query->all($this->db);

        if ($this->sortCallback) {
            usort($models, $this->sortCallback);
        }

        return array_slice($models, $pagination->getOffset(), $pagination->getLimit());
    }

    /**
     * @param callable|null $sortedCallback
     */
    public function setSortCallback(?callable $sortedCallback): void
    {
        $this->sortCallback = $sortedCallback;
    }
}