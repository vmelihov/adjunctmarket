<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "teaching_type".
 *
 * @property int $id
 * @property string $name
 *
 * @property Profile[] $profiles
 * @property Profile[] $profiles0
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

    /**
     * @return ActiveQuery
     */
    public function getProfiles(): ActiveQuery
    {
        return $this->hasMany(Profile::class, ['teach_type_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProfiles0(): ActiveQuery
    {
        return $this->hasMany(Profile::class, ['teaching_experience_type_id' => 'id']);
    }
}
