<?php

namespace frontend\models;

use common\src\helpers\Helper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Vacancy;

/**
 * VacancySearch represents the model behind the search form of `\common\models\Vacancy`.
 */
class VacancySearch extends Vacancy
{
    public const PAGE_SIZE = 5;
    public const FAST_FILTER_ARCHIVE = 'archive';
    public const FAST_FILTER_ACTUAL = 'actual';
    public const FAST_FILTER_RECOMMENDED = 'recommended';

    public $specialities;
    public $areas;
    public $fastFilter;

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
     * @param int $page
     * @return ActiveDataProvider
     */
    public function search($params, int $page = 0): ActiveDataProvider
    {
        $query = Vacancy::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
                'page' => $page,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $dataProvider->setTotalCount($this->getTotalCount());

        $this->applyFastFilter();

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

    protected function applyFastFilter(): void
    {
        if ($this->fastFilter) {
            switch ($this->fastFilter) {
                case self::FAST_FILTER_ARCHIVE:
                    $this->deleted = 1;
                    break;
                case self::FAST_FILTER_ACTUAL:
                    $this->deleted = 0;
                    break;
                case self::FAST_FILTER_RECOMMENDED:
                    $user = Helper::getUserIdentity();

                    if (!$user || !$user->isAdjunct()) {
                        return;
                    }

                    $profile = $user->profile;

                    $this->area_id = $profile->getLocationsArray()[0];
                    $this->education_id = $profile->education_id;
                    $this->teach_type_id = $profile->teach_type_id;
                    $this->teach_time_id = $profile->teach_time_id;

                    break;
            }
        }
    }

    protected function getTotalCount(): int
    {
        $query = Vacancy::find();

        if ($this->institution_user_id) {
            $query->where(['=', 'institution_user_id', $this->institution_user_id]);
        }

        return $query->count();
    }
}
