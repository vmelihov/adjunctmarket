<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "teaching_period".
 *
 * @property int $id
 * @property string $name
 */
class TeachingPeriod extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'teaching_period';
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
