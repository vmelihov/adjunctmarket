<?php

namespace common\models;

use common\src\helpers\Helper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "dialog".
 *
 * @property int $id
 * @property int $vacancy_id
 * @property int $adjunct_user_id
 * @property int $institution_user_id
 *
 * @property User $adjunctUser
 * @property User $institutionUser
 * @property Vacancy $vacancy
 * @property Message[] $messages
 */
class Chat extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'chat';
    }

    /**
     * @param int $id
     * @return array
     */
    public static function findByUserId(int $id): array
    {
        return self::find()
            ->where(['adjunct_user_id' => $id])
            ->orWhere(['institution_user_id' => $id])
            ->all();
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['adjunct_user_id', 'institution_user_id'], 'required'],
            [['vacancy_id', 'adjunct_user_id', 'institution_user_id'], 'integer'],
            [['adjunct_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['adjunct_user_id' => 'id']],
            [['institution_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['institution_user_id' => 'id']],
            [['vacancy_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vacancy::class, 'targetAttribute' => ['vacancy_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'vacancy_id' => 'Vacancy ID',
            'adjunct_user_id' => 'Adjunct User ID',
            'institution_user_id' => 'Institution User ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getAdjunctUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'adjunct_user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getInstitutionUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'institution_user_id']);
    }

    /**
     * @return null|ActiveQuery
     */
    public function getVacancy(): ?ActiveQuery
    {
        if (!$this->vacancy_id) {
            return null;
        }

        return $this->hasOne(Vacancy::class, ['id' => 'vacancy_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMessages(): ActiveQuery
    {
        return $this->hasMany(Message::class, ['chat_id' => 'id'])
            ->orderBy(['created' => SORT_DESC]);
    }

    /**
     * @return User
     */
    public function getOpponentUser(): User
    {
        /** @var User $user */
        $user = Helper::getUserIdentity();

        if ($user->getId() === $this->adjunct_user_id) {
            return $this->institutionUser;
        }

        return $this->adjunctUser;
    }

    /**
     * @param int $vacancyId
     * @param int $adjunctId
     * @return null|ActiveRecord|Chat
     */
    public static function findForVacancyAndAdjunct(int $vacancyId, int $adjunctId): ?ActiveRecord
    {
        return self::find()
            ->where(['vacancy_id' => $vacancyId, 'adjunct_user_id' => $adjunctId])
            ->one();
    }

    /**
     * @param int $institutionId
     * @param int $adjunctId
     * @return null|ActiveRecord|Chat
     */
    public static function findByInstitutionAndAdjunct(int $institutionId, int $adjunctId): ?ActiveRecord
    {
        return self::find()
            ->where(['institution_user_id' => $institutionId, 'adjunct_user_id' => $adjunctId])
            ->one();
    }

}
