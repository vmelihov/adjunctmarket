<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "institution".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $description
 * @property int $location_id
 *
 * @property User $user
 */
class Institution extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'institution';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['title', 'description'], 'string', 'max' => 200],
            [['location_id'], 'exist', 'skipOnError' => true, 'targetClass' => Area::class, 'targetAttribute' => ['location_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'description' => 'Description',
            'location_id' => 'Location',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getArea(): ActiveQuery
    {
        return $this->hasOne(Area::class, ['id' => 'state_id']);
    }
}
