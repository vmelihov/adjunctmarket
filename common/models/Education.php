<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "education".
 *
 * @property int $id
 * @property string $name
 * @property int $min_age
 */
class Education extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'education';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['min_age'], 'integer'],
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
            'min_age' => 'Min Age',
        ];
    }

}
