<?php

namespace frontend\models\profile;

use common\models\User;
use frontend\models\profile\strategy\AdjunctProfile;
use frontend\models\profile\strategy\InstitutionProfile;
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
            return new InstitutionProfile($user);
        }

        throw new Exception('Undefined user type');
    }

}