<?php

namespace frontend\models\Relevance;

use common\models\Adjunct;
use common\models\TeachingPeriod;
use common\models\TeachingTime;
use common\models\TeachingType;

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

        return $teachPeriodId === TeachingPeriod::BOTH ? true : $teachPeriodId == $value;
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
        return $this->adjunct->education == $value;
    }
}