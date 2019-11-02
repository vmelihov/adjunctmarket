<?php

namespace common\src\helpers;

class MySqlHelper
{
    public static function createMultiSelectCondition(string $field, array $values): array
    {
        $valuesStr = '"' . implode('"|"', $values) . '"';

        return ['REGEXP', $field, $valuesStr];
    }
}