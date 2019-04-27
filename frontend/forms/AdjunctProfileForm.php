<?php

namespace frontend\forms;

use common\models\Adjunct;
use yii\base\Model;

/**
 * Signup form
 */
class AdjunctProfileForm extends Model
{
    public $id;
    public $user_id;
    public $title;
    public $description;
    public $age;
    public $sex;
    public $teaching_experience_type_id;
    public $education_id;
    public $teach_type_id;
    public $teach_locations;
    public $teach_time_id;
    public $teach_period_id;
    public $faculties;
    public $confirm;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'user_id',
                    'education_id',
                    'teach_type_id',
                    'teach_time_id',
                    'teach_period_id',
                    'faculties',
                ],
                'required'
            ],
            ['teach_locations', 'safe'],
            [['title','description'], 'trim'],
            [
                [
                    'id',
                    'user_id',
                    'teaching_experience_type_id',
                    'education_id',
                    'teach_type_id',
                    'teach_period_id',
                ],
                'number'
            ],
            ['confirm', 'compare', 'compareValue' => 1, 'message' => 'You must confirm'],
        ];
    }

    /**
     * @return Adjunct|null
     */
    public function save(): ?Adjunct
    {
        if (!$this->validate()) {
            return null;
        }

        if ($this->id) {
            $adjunct = Adjunct::findOne($this->id);
        }

        if (!isset($adjunct)) {
            $adjunct = new Adjunct();
        }

        $adjunct->user_id = $this->user_id;
        $adjunct->title = $this->title;
        $adjunct->description = $this->description;
        $adjunct->education_id = $this->education_id;
        $adjunct->teach_type_id = $this->teach_type_id;
        $adjunct->teach_time_id = $this->teach_time_id;
        $adjunct->teach_period_id = $this->teach_period_id;
        $adjunct->teaching_experience_type_id = $this->teaching_experience_type_id;

        $adjunct->teach_locations = $this->getArrayAsString($this->teach_locations);
        $adjunct->faculties = $this->getArrayAsString($this->faculties);

        return $adjunct->save() ? $adjunct : null;
    }

    /**
     * @param mixed $array
     * @return string|null
     */
    protected function getArrayAsString($array): ?string
    {
        if ($array) {
            return json_encode($array);
        }

        return null;
    }

}
