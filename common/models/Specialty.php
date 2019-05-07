<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "specialty".
 *
 * @property int $id
 * @property string $name
 * @property int $faculty_id
 *
 * @property Faculty $faculty
 */
class Specialty extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'specialty';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'faculty_id'], 'required'],
            [['faculty_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['faculty_id'], 'exist', 'skipOnError' => true, 'targetClass' => Faculty::className(), 'targetAttribute' => ['faculty_id' => 'id']],
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
            'faculty_id' => 'Faculty ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getFaculty(): ActiveQuery
    {
        return $this->hasOne(Faculty::class, ['id' => 'faculty_id']);
    }

    /**
     * @return string
     */
    public function getNameWithFaculty(): string
    {
        return $this->faculty->name . ', ' . $this->name;
    }
}
