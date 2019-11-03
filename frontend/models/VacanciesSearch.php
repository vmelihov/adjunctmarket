<?php

namespace frontend\models;

use common\models\User;
use common\src\helpers\Helper;
use frontend\models\Relevance\AdjunctVacancyRelevance;
use frontend\src\DataProviderWithSort;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Vacancy;
use common\models\TeachingPeriod;

/**
 * VacanciesSearch represents the model behind the search form of `\common\models\Vacancy`.
 */
class VacanciesSearch extends Vacancy
{
    public const PAGE_SIZE = 5;
    public const FAST_FILTER_ARCHIVE = 'archive';
    public const FAST_FILTER_ACTUAL = 'actual';
    public const FAST_FILTER_RECOMMENDED = 'recommended';

    public const SORT_NEWEST = 'newest';
    public const SORT_RELEVANCE = 'Relevance';
    public const SORT_FEWEST_PROPOSALS = 'proposals';

    public $specialities;
    public $areas;
    public $fastFilter;
    public $sort = self::SORT_NEWEST;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'education_id', 'teach_type_id', 'teach_time_id', 'teach_period_id', 'created', 'updated', 'deleted', 'views', 'institution_user_id'], 'integer'],
            [['title', 'description', 'specialities', 'areas', 'sort'], 'safe'],
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
     * @param int $page
     * @return ActiveDataProvider
     */
    public function search($params, int $page = 0): ActiveDataProvider
    {
        $user = Helper::getUserIdentity();
        $query = Vacancy::find();

        $dataProvider = new DataProviderWithSort([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
                'page' => $page,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created' => SORT_ASC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $dataProvider->setTotalCount($this->getTotalCount($user));

        if ($user) {
            $this->applyFastFilter($user);
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

        if (!$user || $user->isAdjunct()) {
            $query->andFilterWhere(['deleted' => 0]);
        } else {
            $query->andFilterWhere(['deleted' => $this->deleted]);
        }

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

        if ($this->sort && $this->sort !== self::SORT_NEWEST) {
            $this->getSortCallback($user, $dataProvider);
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

    /**
     * @param User $user
     */
    protected function applyFastFilter(User $user): void
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
                    if (!$user || !$user->isAdjunct()) {
                        return;
                    }

                    $profile = $user->profile;

                    $this->area_id = $profile->getLocationsArray()[0];
                    $this->education_id = $profile->education_id;
                    $this->teach_type_id = $profile->teach_type_id;
                    $this->teach_time_id = $profile->teach_time_id;

                    if ($profile->teach_period_id == TeachingPeriod::BOTH) {
                        $this->teach_period_id = [TeachingPeriod::FULL_SEMESTER, TeachingPeriod::OCCASIONAL_LECTURING];
                    } else {
                        $this->teach_period_id = [TeachingPeriod::BOTH, $profile->teach_period_id];
                    }

                    break;
            }
        }
    }

    /**
     * @param User|null $user
     * @return int
     */
    protected function getTotalCount(?User $user): int
    {
        $query = Vacancy::find();

        if ($this->institution_user_id) {
            $query->where(['=', 'institution_user_id', $this->institution_user_id]);
        }

        if (!$user || $user->isAdjunct()) {
            $query->andFilterWhere(['deleted' => 0]);
        }

        return $query->count();
    }

    /**
     * @param User|null $user
     * @param DataProviderWithSort $dataProvider
     */
    protected function getSortCallback(?User $user, DataProviderWithSort $dataProvider): void
    {
        $callback = null;

        if ($this->sort == self::SORT_RELEVANCE && $user) {
            $relevance = new AdjunctVacancyRelevance($user->profile);
            $callback = static function (Vacancy $vacancy1, Vacancy $vacancy2) use ($relevance) {
                return $relevance->getCountRelevant($vacancy2) <=> $relevance->getCountRelevant($vacancy1);
            };
        } elseif ($this->sort == self::SORT_FEWEST_PROPOSALS) {
            $callback = static function (Vacancy $vacancy1, Vacancy $vacancy2) {
                return count($vacancy2->proposals) <=> count($vacancy1->proposals);
            };
        }

        $dataProvider->setSortCallback($callback);
    }
}
