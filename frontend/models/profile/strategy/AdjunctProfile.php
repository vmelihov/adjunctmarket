<?php

namespace frontend\models\profile\strategy;

use frontend\forms\AdjunctProfileForm;
use frontend\models\profile\BaseProfile;
use yii\base\Model;

class AdjunctProfile extends BaseProfile
{
    /**
     * @inheritDoc
     */
    public function createForm(): Model
    {
        $user = $this->getUser();
        $form = new AdjunctProfileForm(['user_id' => $user->getId()]);

        if ($user->profile) {
            $attributes = $user->profile->getAttributes();

            $form->setAttributes($attributes);
            $form->teach_locations = json_decode($attributes['teach_locations'], true);
            $form->specialities = implode(' ', json_decode($attributes['specialities'], true));
        }

        return $form;
    }

    /**
     * @return string
     */
    public function getViewName(): string
    {
        return '@frontend/views/adjunct/profile';
    }
}