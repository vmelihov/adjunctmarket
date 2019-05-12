<?php

namespace frontend\forms;

use common\models\Institution;
use common\models\University;
use yii\base\Model;

class InstitutionProfileForm extends Model
{
    public $id;
    public $user_id;
    public $title;
    public $description;
    public $university_id;
    public $confirm;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id', 'university_id'], 'required'],
            [['title', 'description'], 'trim'],
            [['id', 'user_id'], 'number'],
            [['university_id'], 'exist', 'skipOnError' => true, 'targetClass' => University::class, 'targetAttribute' => ['university_id' => 'id']],
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
        $institution->university_id = $this->university_id;

        return $institution->save() ? $institution : null;
    }
}