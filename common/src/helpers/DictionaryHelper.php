<?php

namespace common\src\helpers;

use common\models\Area;
use common\models\Education;
use common\models\Specialty;
use common\models\TeachingPeriod;
use common\models\TeachingTime;
use common\models\TeachingType;
use common\models\University;
use yii\helpers\ArrayHelper;

class DictionaryHelper
{
    /** @var array */
    protected $result = [];

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }

    /**
     * @param string $val
     * @return DictionaryHelper
     */
    public function addFirsEmptyElement($val = ''): self
    {
        array_unshift($this->result, $val);
        return $this;
    }

    /**
     * @return DictionaryHelper
     */
    public function prepareSpecialties(): self
    {
        $this->result = ArrayHelper::map(Specialty::find()->orderBy('name')->all(), 'id', 'name');
        return $this;
    }

    /**
     * @return DictionaryHelper
     */
    public function prepareSpecialtiesWithFacultyGroup(): self
    {
        $this->result = ArrayHelper::map(Specialty::findWithFacultyName(), 'id', 'name', 'faculty');
        return $this;
    }

    /**
     * @return DictionaryHelper
     */
    public function prepareArea(): self
    {
        $this->result = ArrayHelper::map(Area::find()->all(), 'id', 'name');
        return $this;
    }

    /**
     * @return DictionaryHelper
     */
    public function prepareAreaWithState(): self
    {
        $this->result = ArrayHelper::map(Area::find()->all(), 'id', 'nameWithState');
        return $this;
    }

    /**
     * @return DictionaryHelper
     */
    public function prepareEducation(): self
    {
        $this->result = ArrayHelper::map(Education::find()->all(), 'id', 'name');
        return $this;
    }

    /**
     * @return DictionaryHelper
     */
    public function prepareTeachingType(): self
    {
        $this->result = ArrayHelper::map(TeachingType::find()->all(), 'id', 'name');
        return $this;
    }

    /**
     * @return DictionaryHelper
     */
    public function prepareTeachingTime(): self
    {
        $this->result = ArrayHelper::map(TeachingTime::find()->all(), 'id', 'name');
        return $this;
    }

    /**
     * @return DictionaryHelper
     */
    public function prepareTeachingPeriod(): self
    {
        $this->result = ArrayHelper::map(TeachingPeriod::find()->all(), 'id', 'name');
        return $this;
    }

    /**
     * @return DictionaryHelper
     */
    public function prepareUniversity(): self
    {
        $this->result = ArrayHelper::map(University::find()->all(), 'id', 'name');
        return $this;
    }

}