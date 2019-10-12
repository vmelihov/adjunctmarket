<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "vacancy".
 *
 * @property int $id
 * @property int $institution_user_id
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
 * @property User $user
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
    public static function tableName(): string
    {
        return 'vacancy';
    }

    public function behaviors(): array
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
    public function rules(): array
    {
        return [
            [['institution_user_id', 'title', 'description', 'specialty_id'], 'required'],
            [['institution_user_id', 'specialty_id', 'area_id', 'education_id', 'teach_type_id', 'teach_time_id', 'teach_period_id', 'created', 'updated', 'deleted', 'views'], 'integer'],
            [['title', 'description'], 'string', 'max' => 3000],
            [['education_id'], 'exist', 'skipOnEmpty' => true, 'skipOnError' => true, 'targetClass' => Education::class, 'targetAttribute' => ['education_id' => 'id']],
            [['specialty_id'], 'exist', 'skipOnError' => true, 'targetClass' => Specialty::class, 'targetAttribute' => ['specialty_id' => 'id']],
            [['institution_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['institution_user_id' => 'id']],
            [['area_id'], 'exist', 'skipOnEmpty' => true, 'skipOnError' => true, 'targetClass' => Area::class, 'targetAttribute' => ['area_id' => 'id']],
            [['teach_period_id'], 'exist', 'skipOnError' => true, 'targetClass' => TeachingPeriod::class, 'targetAttribute' => ['teach_period_id' => 'id']],
            [['teach_time_id'], 'exist', 'skipOnError' => true, 'targetClass' => TeachingTime::class, 'targetAttribute' => ['teach_time_id' => 'id']],
            [['teach_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TeachingType::class, 'targetAttribute' => ['teach_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'institution_user_id' => 'User ID',
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
    public function getEducation(): ActiveQuery
    {
        return $this->hasOne(Education::class, ['id' => 'education_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSpecialty(): ActiveQuery
    {
        return $this->hasOne(Specialty::class, ['id' => 'specialty_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'institution_user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getArea(): ActiveQuery
    {
        return $this->hasOne(Area::class, ['id' => 'area_id']);
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
     * @param int $id
     * @return Vacancy[]
     */
    public static function findByInstitutionUserId(int $id): array
    {
        return self::findAll(['institution_user_id' => $id]);
    }

    /**
     * @return Vacancy[]
     */
    public static function findAllToShow(): array
    {
        return self::findAll(['deleted' => 0]);
    }
}
