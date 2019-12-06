<?php

namespace frontend\models\profile\strategy;

use frontend\forms\InstitutionProfileForm;
use frontend\models\profile\BaseProfile;
use yii\base\Model;

class InstitutionProfile extends BaseProfile
{
    /**
     * @inheritDoc
     */
    public function createForm(): Model
    {
        $user = $this->getUser();
        $form = new InstitutionProfileForm([
            'user_id' => $user->getId(),
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
        ]);

        if ($user->profile) {
            $form->setAttributes($user->profile->getAttributes());
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
        return 'institution';
    }
}