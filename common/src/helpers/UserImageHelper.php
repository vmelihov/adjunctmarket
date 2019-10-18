<?php

namespace common\src\helpers;

use common\models\User;
use yii\helpers\Url;

class UserImageHelper
{
    /**
     * @return string
     */
    public static function generateImageName(User $user): string
    {
        return $user->getId() . '_avatar';
    }

    /**
     * @param User $user
     * @return string
     */
    public static function getUserImageUrl(User $user): string
    {
        if ($user->image) {
            return Url::to('@web/user/') . $user->image;
        }

        return Url::to('@web/img/default_avatar.jpg');
    }
}