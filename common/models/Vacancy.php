<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "vacancy".
 *
 * @property int $id
 * @property int $institution_id
 * @property string $title
 * @property string $description
 * @property int $specialty_id
 * @property int $area_id
 * @property int $education_id
 * @property int $teach_type_id
 * @property int $teach_time_id
 * @property int $teach_period_id
 * @property int $created
 * @property int $updated
 * @property int $deleted
 * @property int $views
 *
 * @property Education $education
 * @property Specialty $specialty
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

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created',
                'updatedAtAttribute' => 'updated',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['institution_id', 'title', 'description', 'specialty_id', 'area_id', 'education_id', 'teach_type_id', 'teach_time_id', 'teach_period_id'], 'required'],
            [['institution_id', 'specialty_id', 'area_id', 'education_id', 'teach_type_id', 'teach_time_id', 'teach_period_id', 'created', 'updated', 'deleted', 'views'], 'integer'],
            [['title', 'description'], 'string', 'max' => 200],
            [['education_id'], 'exist', 'skipOnError' => true, 'targetClass' => Education::class, 'targetAttribute' => ['education_id' => 'id']],
            [['specialty_id'], 'exist', 'skipOnError' => true, 'targetClass' => Specialty::class, 'targetAttribute' => ['specialty_id' => 'id']],
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
            'specialty_id' => 'Specialty',
            'area_id' => 'Area ID',
            'education_id' => 'Education ID',
            'teach_type_id' => 'Teach Type ID',
            'teach_time_id' => 'Teach Time ID',
            'teach_period_id' => 'Teach Period ID',
            'created' => 'Created time',
            'updated' => 'Updated time',
            'deleted' => 'Deleted',
            'views' => 'Views',
        ];
    }

    /**
     * @param int $id
     */
    public static function incrementView(int $id): void
    {
        $vacancy = self::findOne($id);

        if ($vacancy) {
            $vacancy->updateCounters(['views' => 1]);
        }
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
    public function getSpecialty()
    {
        return $this->hasOne(Specialty::class, ['id' => 'specialty_id']);
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
     * @return Vacancy[]
     */
    public static function findByInstitutionId(int $id): array
    {
        return self::findAll(['institution_id' => $id]);
    }

    /**
     * @return Vacancy[]
     */
    public static function findAllToShow(): array
    {
        return self::findAll(['deleted' => 0]);
    }
}
