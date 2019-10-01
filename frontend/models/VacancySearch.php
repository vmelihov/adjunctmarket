<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Vacancy;

/**
 * VacancySearch represents the model behind the search form of `\common\models\Vacancy`.
 */
class VacancySearch extends Vacancy
{
    public $specialities;
    public $areas;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'education_id', 'teach_type_id', 'teach_time_id', 'teach_period_id', 'created', 'updated', 'deleted', 'views', 'institution_user_id'], 'integer'],
            [['title', 'description', 'specialities', 'areas'], 'safe'],
        ];
    }

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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Vacancy::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'area_id' => $this->area_id,
            'education_id' => $this->education_id,
            'teach_type_id' => $this->teach_type_id,
            'teach_time_id' => $this->teach_time_id,
            'teach_period_id' => $this->teach_period_id,
            'created' => $this->created,
            'updated' => $this->updated,
            'deleted' => $this->deleted,
            'views' => $this->views,
            'institution_user_id' => $this->institution_user_id,
        ]);

        $specialtyIds = $this->getSpecialtyIds();
        if ($specialtyIds) {
            $query->andFilterWhere(['in', 'specialty_id', $specialtyIds]);
        }

        $areaIds = $this->getAreaIds();
        if ($areaIds) {
            $query->andFilterWhere(['in', 'area_id', $areaIds]);
        }

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

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
}
