<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "profile".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $age
 * @property int $sex
 * @property int $teaching_experience_type_id
 * @property int $education_id
 * @property int $teach_type_id
 * @property string $teach_locations
 * @property int $teach_time_id
 * @property int $teach_period_id
 * @property string $faculties
 *
 * @property Education $education
 * @property TeachingPeriod $teachPeriod
 * @property TeachingTime $teachTime
 * @property TeachingType $teachType
 * @property TeachingType $teachingExperienceType
 */
class Profile extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title', 'description'], 'required'],
            [['age', 'sex', 'teaching_experience_type_id', 'education_id', 'teach_type_id', 'teach_time_id', 'teach_period_id'], 'integer'],
            [['title', 'description'], 'string', 'max' => 200],
            [['teach_locations', 'faculties'], 'string', 'max' => 255],
            [['education_id'], 'exist', 'skipOnError' => true, 'targetClass' => Education::class, 'targetAttribute' => ['education_id' => 'id']],
            [['teach_period_id'], 'exist', 'skipOnError' => true, 'targetClass' => TeachingPeriod::class, 'targetAttribute' => ['teach_period_id' => 'id']],
            [['teach_time_id'], 'exist', 'skipOnError' => true, 'targetClass' => TeachingTime::class, 'targetAttribute' => ['teach_time_id' => 'id']],
            [['teach_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TeachingType::class, 'targetAttribute' => ['teach_type_id' => 'id']],
            [['teaching_experience_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TeachingType::class, 'targetAttribute' => ['teaching_experience_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'age' => 'Age',
            'sex' => 'Sex',
            'teaching_experience_type_id' => 'Teaching Experience Type ID',
            'education_id' => 'Education ID',
            'teach_type_id' => 'Teach Type ID',
            'teach_locations' => 'Teach Locations',
            'teach_time_id' => 'Teach Time ID',
            'teach_period_id' => 'Teach Period ID',
            'faculties' => 'Faculties',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getEducation(): ActiveQuery
    {
        return $this->hasOne(Education::class, ['id' => 'education_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeachPeriod(): ActiveQuery
    {
        return $this->hasOne(TeachingPeriod::class, ['id' => 'teach_period_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeachTime(): ActiveQuery
    {
        return $this->hasOne(TeachingTime::class, ['id' => 'teach_time_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeachType(): ActiveQuery
    {
        return $this->hasOne(TeachingType::class, ['id' => 'teach_type_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeachingExperienceType(): ActiveQuery
    {
        return $this->hasOne(TeachingType::class, ['id' => 'teaching_experience_type_id']);
    }
}
