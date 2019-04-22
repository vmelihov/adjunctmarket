<?php

namespace frontend\models\profile;

use common\models\User;
use frontend\models\profile\strategy\AdjunctProfile;
use yii\db\Exception;
use yii\web\IdentityInterface;

class ProfileBuilder
{
    /**
     * @param User|IdentityInterface $user
     * @return BaseProfile
     * @throws Exception
     */
    public static function build(User $user): BaseProfile
    {
        if ($user->user_type === User::TYPE_ADJUNCT) {
            return new AdjunctProfile($user);
        }

        if ($user->user_type === User::TYPE_INSTITUTION) {
            throw new Exception('InstitutionForm is not implemented');
        }

        throw new Exception('Undefined type');
    }

}