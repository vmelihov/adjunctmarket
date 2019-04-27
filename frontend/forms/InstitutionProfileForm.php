<?php

namespace frontend\forms;

use common\models\Area;
use common\models\Institution;
use yii\base\Model;

class InstitutionProfileForm extends Model
{
    public $id;
    public $user_id;
    public $title;
    public $description;
    public $location_id;
    public $confirm;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id', 'location_id'], 'required'],
            [['title', 'description'], 'trim'],
            [['id', 'user_id'], 'number'],
            [['location_id'], 'exist', 'skipOnError' => true, 'targetClass' => Area::class, 'targetAttribute' => ['location_id' => 'id']],
            ['confirm', 'compare', 'compareValue' => 1, 'message' => 'You must confirm'],
        ];
    }

    /**
     * @return Institution|null
     */
    public function save(): ?Institution
    {
        if (!$this->validate()) {
            return null;
        }

        if ($this->id) {
            $institution = Institution::findOne($this->id);
        }

        if (!isset($institution)) {
            $institution = new Institution();
        }

        $institution->user_id = $this->user_id;
        $institution->title = $this->title;
        $institution->description = $this->description;
        $institution->location_id = $this->location_id;

        return $institution->save() ? $institution : null;
    }
}