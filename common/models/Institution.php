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
 * @property string $position
 * @property int $university_id
 * @property string $favorite_adjuncts
 *
 * @property User $user
 * @property University $university
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
            [['title', 'description', 'position'], 'string', 'max' => 200],
            [['university_id'], 'exist', 'skipOnError' => true, 'targetClass' => University::class, 'targetAttribute' => ['university_id' => 'id']],
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
            'university_id' => 'University',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUniversity(): ActiveQuery
    {
        return $this->hasOne(University::class, ['id' => 'university_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return Adjunct[]
     */
    public function getFavoriteAdjuncts(): array
    {
        return Adjunct::findAll($this->getFavoriteAdjunctsArray());
    }

    /**
     * @return array
     */
    public function getFavoriteAdjunctsArray(): array
    {
        return json_decode($this->favorite_adjuncts, true) ?? [];
    }

    /**
     * @param array $ids
     */
    public function setFavoriteAdjunctsArray(array $ids): void
    {
        $this->favorite_adjuncts = json_encode(array_values($ids));
    }

    /**
     * @param int $id
     * @return bool
     */
    public function isFavoriteAdjunct(int $id): bool
    {
        return in_array($id, $this->getFavoriteAdjunctsArray(), true);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function addFavoriteAdjunct(int $id): bool
    {
        $array = $this->getFavoriteAdjunctsArray();
        $array[] = $id;
        $this->setFavoriteAdjunctsArray($array);

        return $this->save();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function removeFavoriteAdjunct(int $id): bool
    {
        $array = $this->getFavoriteAdjunctsArray();
        $key = array_search($id, $array, true);

        if ($key !== false) {
            unset($array[$key]);
            $this->setFavoriteAdjunctsArray($array);

            return $this->save();
        }

        return true;
    }
}
