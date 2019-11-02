<?php

namespace frontend\models;

use common\models\User;
use common\src\helpers\MySqlHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Adjunct;
use yii\db\ActiveQuery;

/**
 * AdjunctSearch.php represents the model behind the search form of `\common\models\Adjunct`.
 */
class AdjunctSearch extends Adjunct
{
    public const PAGE_SIZE = 5;

    public $specialities;
    public $areas;

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param int $page
     * @return ActiveDataProvider
     */
    public function search($params, int $page = 0): ActiveDataProvider
    {
        $query = $this->getBaseQuery();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $dataProvider->setTotalCount($this->getTotalCount());

        $query->andFilterWhere([
            'id' => $this->id,
            'education_id' => $this->education_id,
            'teach_type_id' => $this->teach_type_id,
            'teach_time_id' => $this->teach_time_id,
            'teach_period_id' => $this->teach_period_id,
        ]);

        $specialtyIds = $this->getSpecialtyIds();
        if ($specialtyIds) {
            $conditionSpec = MySqlHelper::createMultiSelectCondition('specialities', $specialtyIds);
            $query->andFilterWhere($conditionSpec);
        }

        $areaIds = $this->getAreaIds();
        if ($areaIds) {
            $conditionArea = MySqlHelper::createMultiSelectCondition('area_id', $areaIds);
            $query->andFilterWhere($conditionArea);
        }

        return $dataProvider;
    }

    /**
     * @return array
     */
    protected function getSpecialtyIds(): array
    {
        return $this->specialities ? explode(' ', trim($this->specialities)) : [];
    }

    /**
     * @return array
     */
    protected function getAreaIds(): array
    {
        return $this->areas ? explode(' ', trim($this->areas)) : [];
    }

    protected function getTotalCount(): int
    {
        return $this->getBaseQuery()->count();
    }

    /**
     * @return ActiveQuery
     */
    protected function getBaseQuery(): ActiveQuery
    {
        return Adjunct::find()
            ->joinWith('user', false)
            ->where(['=', 'user.user_type', User::TYPE_ADJUNCT])
            ->andWhere(['=', 'user.status', User::STATUS_ACTIVE]);
    }
}
