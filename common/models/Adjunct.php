<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "adjunct".
 *
 * @property int $id
 * @property int $user_id
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
 * @property string $specialities
 *
 * @property Education $education
 * @property TeachingPeriod $teachPeriod
 * @property TeachingTime $teachTime
 * @property TeachingType $teachType
 * @property TeachingType $teachingExperienceType
 * @property User $user
 */
class Adjunct extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'adjunct';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array 
    {
        return [
            [['age', 'sex', 'education_id', 'teach_type_id', 'teach_time_id', 'teach_period_id'], 'integer'],
            [['title', 'description'], 'string', 'max' => 200],
            [['teach_locations', 'specialities', 'teaching_experience_type_id'], 'string', 'max' => 255],
            [['education_id'], 'exist', 'skipOnError' => true, 'targetClass' => Education::class, 'targetAttribute' => ['education_id' => 'id']],
            [['teach_period_id'], 'exist', 'skipOnError' => true, 'targetClass' => TeachingPeriod::class, 'targetAttribute' => ['teach_period_id' => 'id']],
            [['teach_time_id'], 'exist', 'skipOnError' => true, 'targetClass' => TeachingTime::class, 'targetAttribute' => ['teach_time_id' => 'id']],
            [['teach_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TeachingType::class, 'targetAttribute' => ['teach_type_id' => 'id']],
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
            'age' => 'Age',
            'sex' => 'Sex',
            'teaching_experience_type_id' => 'Teaching Experience Type ID',
            'education_id' => 'Education ID',
            'teach_type_id' => 'Teach Type ID',
            'teach_locations' => 'Teach Locations',
            'teach_time_id' => 'Teach Time ID',
            'teach_period_id' => 'Teach Period ID',
            'specialities' => 'Specialities',
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
     * @return ActiveQuery|User
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @param int $userId
     * @return Adjunct
     */
    public static function findByUserId(int $userId): self
    {
        return self::findOne(['user_id' => $userId]);
    }

    public function getSpecialitiesArray(): array
    {
        return json_decode($this->specialities, true);
    }

    public function getLocationsArray(): array
    {
        $decoded = json_decode($this->teach_locations, true);

        return is_array($decoded) ? $decoded : [$decoded];
    }

    /**
     * @return Area[]
     */
    public function getLocations(): array
    {
        $locationIds = $this->getLocationsArray();

        return Area::find()->where(['in', 'id', $locationIds])->all();
    }

    /**
     * @param Vacancy $vacancy
     * @return self[]
     * todo вынести в AdjunctVacancyRelevance
     */
    public static function getSuitableForVacancy(Vacancy $vacancy): array
    {
        $query = self::find();

        if ($vacancy->education_id) {
            $query->andWhere(['education_id' => $vacancy->education_id]);
        }
        if ($vacancy->teach_type_id) {
            $query->andWhere(['teach_type_id' => $vacancy->teach_type_id]);
        }
        if ($vacancy->teach_time_id) {
            $query->andWhere(['teach_time_id' => $vacancy->teach_time_id]);
        }
        if ($vacancy->teach_period_id) {
            $query->andWhere(['teach_period_id' => $vacancy->teach_period_id]);
        }

        $res = $query->limit(5)->all();

        /** @var Adjunct $item */
        foreach ($res as $key => $item) {
            if (
                ($vacancy->area_id && !in_array($vacancy->area_id, $item->getLocationsArray()))
                || ($vacancy->specialty_id && !in_array($vacancy->specialty_id, $item->getSpecialitiesArray()))
            ) {
                unset($res[$key]);
            }
        }

        return $res;
    }
}
