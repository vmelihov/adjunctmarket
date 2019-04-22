<?php

namespace frontend\models\profile\strategy;

use frontend\forms\AdjunctForm;
use frontend\models\profile\BaseProfile;
use yii\base\Model;

class AdjunctProfile extends BaseProfile
{
    public function createForm(int $userId, array $attributes): Model
    {
        $form = new AdjunctForm(['user_id' => $userId]);

        if ($attributes) {
            $form->setAttributes($attributes);
            $form->teach_locations = json_decode($attributes['teach_locations'], true);
            $form->faculties = json_decode($attributes['faculties'], true);
        }

        return $form;
    }

    /**
     * @return string
     */
    public function getViewName(): string
    {
        return 'adjunct';
    }
}