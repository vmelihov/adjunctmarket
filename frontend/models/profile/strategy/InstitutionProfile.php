<?php

namespace frontend\models\profile\strategy;

use frontend\forms\InstitutionProfileForm;
use frontend\models\profile\BaseProfile;
use yii\base\Model;

class InstitutionProfile extends BaseProfile
{
    /**
     * @param int $userId
     * @param array $attributes
     * @return Model
     */
    public function createForm(int $userId, array $attributes): Model
    {
        $form = new InstitutionProfileForm(['user_id' => $userId]);

        if ($attributes) {
            $form->setAttributes($attributes);
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