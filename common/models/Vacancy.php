<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "vacancy".
 *
 * @property int $id
 * @property int $institution_id
 * @property string $title
 * @property string $description
 * @property int $faculty_id
 * @property int $area_id
 * @property int $education_id
 * @property int $teach_type_id
 * @property int $teach_time_id
 * @property int $teach_period_id
 * @property int $deleted
 *
 * @property Education $education
 * @property Faculty $faculty
 * @property Institution $institution
 * @property Area $area
 * @property TeachingPeriod $teachPeriod
 * @property TeachingTime $teachTime
 * @property TeachingType $teachType
 */
class Vacancy extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vacancy';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['institution_id', 'title', 'description', 'faculty_id', 'area_id', 'education_id', 'teach_type_id', 'teach_time_id', 'teach_period_id'], 'required'],
            [['institution_id', 'faculty_id', 'area_id', 'education_id', 'teach_type_id', 'teach_time_id', 'teach_period_id', 'deleted'], 'integer'],
            [['title', 'description'], 'string', 'max' => 200],
            [['institution_id'], 'unique'],
            [['education_id'], 'exist', 'skipOnError' => true, 'targetClass' => Education::class, 'targetAttribute' => ['education_id' => 'id']],
            [['faculty_id'], 'exist', 'skipOnError' => true, 'targetClass' => Faculty::class, 'targetAttribute' => ['faculty_id' => 'id']],
            [['institution_id'], 'exist', 'skipOnError' => true, 'targetClass' => Institution::class, 'targetAttribute' => ['institution_id' => 'id']],
            [['area_id'], 'exist', 'skipOnError' => true, 'targetClass' => Area::class, 'targetAttribute' => ['area_id' => 'id']],
            [['teach_period_id'], 'exist', 'skipOnError' => true, 'targetClass' => TeachingPeriod::class, 'targetAttribute' => ['teach_period_id' => 'id']],
            [['teach_time_id'], 'exist', 'skipOnError' => true, 'targetClass' => TeachingTime::class, 'targetAttribute' => ['teach_time_id' => 'id']],
            [['teach_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TeachingType::class, 'targetAttribute' => ['teach_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'institution_id' => 'Institution ID',
            'title' => 'Title',
            'description' => 'Description',
            'faculty_id' => 'Faculty ID',
            'area_id' => 'Area ID',
            'education_id' => 'Education ID',
            'teach_type_id' => 'Teach Type ID',
            'teach_time_id' => 'Teach Time ID',
            'teach_period_id' => 'Teach Period ID',
            'deleted' => 'Deleted',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getEducation()
    {
        return $this->hasOne(Education::class, ['id' => 'education_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getFaculty()
    {
        return $this->hasOne(Faculty::class, ['id' => 'faculty_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getInstitution()
    {
        return $this->hasOne(Institution::class, ['id' => 'institution_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getArea()
    {
        return $this->hasOne(Area::class, ['id' => 'area_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeachPeriod()
    {
        return $this->hasOne(TeachingPeriod::class, ['id' => 'teach_period_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeachTime()
    {
        return $this->hasOne(TeachingTime::class, ['id' => 'teach_time_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeachType()
    {
        return $this->hasOne(TeachingType::class, ['id' => 'teach_type_id']);
    }

    /**
     * @param int $id
     * @return ActiveQuery
     */
    public static function findByInstitutionId(int $id): ActiveQuery
    {
        return self::find()->with(['institution_id' => $id]);
    }
}
