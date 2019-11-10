<?php

namespace common\models;

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
     * @param User $user
     * @return array
     */
    public static function findListByUser(User $user): array
    {
        $query = self::find();

        if ($user->isAdjunct()) {
            $query->where(['adjunct_user_id' => $user->getId()]);
        } elseif ($user->isInstitution()) {
            $query->where(['institution_user_id' => $user->getId()]);
        } else {
            return [];
        }

        return $query->all();
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
     * @param bool $sort
     * @return ActiveQuery
     */
    public function getMessages(bool $sort = true): ActiveQuery
    {
        $query = $this->hasMany(Message::class, ['chat_id' => 'id']);

        if ($sort) {
            $query->orderBy(['created' => SORT_ASC]);
        }

        return $query;
    }

    /**
     * @param User $user
     * @return User
     */
    public function getOpponentUser(User $user): User
    {
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
    public static function findForVacancyAndAdjunct(int $vacancyId, int $adjunctId): ?self
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
    public static function findByInstitutionAndAdjunct(int $institutionId, int $adjunctId): ?self
    {
        return self::find()
            ->where(['institution_user_id' => $institutionId, 'adjunct_user_id' => $adjunctId])
            ->one();
    }

    /**
     * @param int $vacancyId
     * @param int $adjunctId
     * @return Chat|ActiveRecord|null
     */
    public static function findByVacancyAndAdjunct(int $vacancyId, int $adjunctId): ?self
    {
        return self::find()
            ->where(['vacancy_id' => $vacancyId, 'adjunct_user_id' => $adjunctId])
            ->one();
    }

    /**
     * @param int $userId
     * @return Message[]
     */
    public function getUnreadMessagesForUserId(int $userId): array
    {
        return $this->getMessages(false)
            ->andWhere(['<>', 'author_user_id', $userId])
            ->andWhere(['read' => Message::STATUS_UNREAD])
            ->all();
    }

    /**
     * @param int $userId
     * @return int
     */
    public function getCountUnreadMessagesForUserId(int $userId): int
    {
        return $this->getMessages(false)
            ->andWhere(['<>', 'author_user_id', $userId])
            ->andWhere(['read' => Message::STATUS_UNREAD])
            ->count();
    }

    /**
     * @return ActiveRecord|Message
     */
    public function getLastMessage(): ActiveRecord
    {
        return $this->getMessages()->one();
    }

}
