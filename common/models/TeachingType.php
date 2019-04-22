<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "teaching_type".
 *
 * @property int $id
 * @property string $name
 */
class TeachingType extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'teaching_type';
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
