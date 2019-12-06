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

        $form = new AdjunctProfileForm([
            'user_id' => $user->getId(),
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
        ]);

        if ($user->profile) {
            $attributes = $user->profile->getAttributes();

            $form->setAttributes($attributes);
            $form->teach_locations = json_decode($attributes['teach_locations'], true);
            $form->specialities = implode(' ', json_decode($attributes['specialities'], true));
            $form->documents = json_decode($attributes['documents'], true);
        } else {
            $form->save();
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