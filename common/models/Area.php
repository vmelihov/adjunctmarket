<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * This is the model class for table "area".
 *
 * @property int $id
 * @property string $name
 * @property int $state_id
 *
 * @property State $state
 */
class Area extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'area';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'state_id'], 'required'],
            [['state_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => State::class, 'targetAttribute' => ['state_id' => 'id']],
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
            'state_id' => 'State ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getState(): ActiveQuery
    {
        return $this->hasOne(State::class, ['id' => 'state_id']);
    }

    /**
     * @return string
     */
    public function getNameWithState(): string
    {
        return $this->state->name . ', ' . $this->name;
    }

    /**
     * @return array
     */
    public static function findWithStateName(): array
    {
        $rows = (new Query())
            ->select(['area.id', 'area.name', 'state.name as state'])
            ->from('area')
            ->innerJoin('state', 'area.state_id = state.id')
            ->all();

        return $rows;
    }
}
