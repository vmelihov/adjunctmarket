<?php

namespace common\src\helpers;

use common\models\User;
use RuntimeException;
use Yii;
use yii\base\Exception;
use yii\helpers\FileHelper;
use yii\helpers\Url;

class UserImageHelper
{
    /**
     * @param User $user
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
    public static function getUrl(User $user): string
    {
        if ($user->image) {
            return Url::to('@web/user/') . $user->id . '/' . $user->image;
        }

        return Url::to('@web/img/default_avatar.jpg');
    }

    /**
     * @param User $user
     * @return bool
     * @throws Exception
     */
    public static function unlinkUserImage(User $user): bool
    {
        $file = self::getUserFolder($user) . '/' . $user->image;

        if (is_file($file)) {
            return FileHelper::unlink($file);
        }

        return true;
    }

    /**
     * @param User $user
     * @return string
     * @throws Exception
     */
    public static function getUserFolder(User $user): string
    {
        $path = Yii::getAlias('@webroot/user/') . $user->id;

        if (FileHelper::createDirectory($path)) {
            return $path;
        }

        throw new RuntimeException(sprintf('Directory "%s" was not created', $path));
    }
}