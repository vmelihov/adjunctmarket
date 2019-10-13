<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "teaching_time".
 *
 * @property int $id
 * @property string $name
 */
class TeachingTime extends ActiveRecord
{
    public const DURING_THE_DAY = 1;
    public const EVENINGS_ONLY = 2;
    public const WEEKENDS = 3;
    public const EVENINGS_AND_WEEKENDS = 4;
    public const EITHER_OF_THE_THREE = 5;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'teaching_time';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

}
