<?php

namespace common\models;

use common\src\helpers\FileHelper;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "proposal".
 *
 * @property int $id
 * @property string $letter
 * @property int $state
 * @property int $created
 * @property int $updated
 * @property int $adjunct_id
 * @property int $vacancy_id
 * @property string $attaches
 *
 * @property User $adjunct
 * @property Vacancy $vacancy
 */
class Proposal extends ActiveRecord
{
    public const STATE_ACTIVE = 1;
    public const STATE_INACTIVE = 2;
    public const STATE_DELETED = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'proposal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['adjunct_id', 'vacancy_id'], 'required'],
            [['id', 'state', 'created', 'updated', 'adjunct_id', 'vacancy_id'], 'integer'],
            [['letter'], 'string', 'max' => 4000],
            [['id'], 'unique'],
            [['attaches'], 'string', 'max' => 400],
            [['adjunct_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['adjunct_id' => 'id']],
            [['vacancy_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vacancy::class, 'targetAttribute' => ['vacancy_id' => 'id']],
        ];
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
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'letter' => 'Letter',
            'state' => 'State',
            'created' => 'Created',
            'updated' => 'Updated',
            'adjunct_id' => 'Adjunct ID',
            'vacancy_id' => 'Vacancy ID',
            'attaches' => 'Attaches',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getAdjunct(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'adjunct_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getVacancy(): ActiveQuery
    {
        return $this->hasOne(Vacancy::class, ['id' => 'vacancy_id']);
    }

    /**
     * @return array
     */
    public function getAttachesArray(): array
    {
        return $this->attaches ? json_decode($this->attaches, true) : [];
    }

    /**
     * @return array
     */
    public function getAttachesUrlArray(): array
    {
        $result = [];

        foreach ($this->getAttachesArray() as $fileName) {
            $result[$fileName] = FileHelper::getVacancyUrl($this->adjunct_id, $this->vacancy_id) . '/' . $fileName;
        }

        return $result;
    }
}
