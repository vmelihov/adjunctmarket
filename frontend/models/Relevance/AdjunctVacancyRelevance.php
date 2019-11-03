<?php

namespace frontend\models\Relevance;

use common\models\Adjunct;
use common\models\TeachingPeriod;
use common\models\TeachingTime;
use common\models\TeachingType;
use common\models\Vacancy;

class AdjunctVacancyRelevance
{
    /** @var Adjunct */
    private $adjunct;

    public function __construct(Adjunct $adjunct)
    {
        $this->adjunct = $adjunct;
    }

    /**
     * @return Adjunct
     */
    public function getAdjunct(): Adjunct
    {
        return $this->adjunct;
    }

    /**
     * @param $value
     * @return bool
     */
    public function isTeachTypeRelevant($value): bool
    {
        $teachTypeId = $this->getAdjunct()->teach_type_id;

        return $teachTypeId === TeachingType::BOTH ? true : $teachTypeId == $value;
    }

    /**
     * @param $value
     * @return bool
     */
    public function isTeachPeriodRelevant($value): bool
    {
        $teachPeriodId = $this->getAdjunct()->teach_period_id;

        if ($teachPeriodId === TeachingPeriod::BOTH || $value == TeachingPeriod::BOTH) {
            return true;
        }

        return $teachPeriodId == $value;
    }

    /**
     * @param $value
     * @return bool
     */
    public function isTeachTimeRelevant($value): bool
    {
        $teachTimeId = $this->getAdjunct()->teach_time_id;

        if ($teachTimeId === TeachingTime::EITHER_OF_THE_THREE) {
            return true;
        }

        if (
            $teachTimeId === TeachingTime::EVENINGS_AND_WEEKENDS
            && ($value == TeachingTime::EVENINGS_ONLY || $value == TeachingTime::WEEKENDS)
        ) {
            return true;
        }

        return $value == TeachingTime::DURING_THE_DAY;
    }

    /**
     * @param $value
     * @return bool
     */
    public function isLocationRelevant($value): bool
    {
        return in_array($value, $this->adjunct->getLocationsArray());
    }

    /**
     * @param $value
     * @return bool
     */
    public function isEducationRelevant($value): bool
    {
        return $this->adjunct->education_id == $value;
    }

    /**
     * @param Vacancy $vacancy
     * @return bool
     */
    public function isFullRelevant(Vacancy $vacancy): bool
    {
        if (!$this->isTeachTypeRelevant($vacancy->teach_type_id)) {
            return false;
        }

        if (!$this->isTeachPeriodRelevant($vacancy->teach_period_id)) {
            return false;
        }

        if (!$this->isTeachTimeRelevant($vacancy->teach_time_id)) {
            return false;
        }

        if (!$this->isLocationRelevant($vacancy->area_id)) {
            return false;
        }

        if (!$this->isEducationRelevant($vacancy->education_id)) {
            return false;
        }

        return true;
    }

    /**
     * @param Vacancy $vacancy
     * @return int
     */
    public function getCountRelevant(Vacancy $vacancy): int
    {
        $result = 0;

        if ($this->isTeachTypeRelevant($vacancy->teach_type_id)) {
            $result++;
        }

        if ($this->isTeachPeriodRelevant($vacancy->teach_period_id)) {
            $result++;
        }

        if ($this->isTeachTimeRelevant($vacancy->teach_time_id)) {
            $result++;
        }

        if ($this->isLocationRelevant($vacancy->area_id)) {
            $result++;
        }

        if ($this->isEducationRelevant($vacancy->education_id)) {
            $result++;
        }

        return $result;
    }
}