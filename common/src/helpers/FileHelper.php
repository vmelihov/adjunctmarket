<?php

namespace common\src\helpers;

use common\models\User;
use RuntimeException;
use Yii;
use yii\base\Exception;
use yii\helpers\FileHelper as YiiFileHelper;

class FileHelper
{
    /**
     * @param User $user
     * @return string
     * @throws Exception
     */
    public static function getUserFolder(User $user): string
    {
        $path = Yii::getAlias('@webroot/user/') . $user->id;

        return self::create($path);
    }

    /**
     * @param User $user
     * @param int $vacancy_id
     * @return string
     * @throws Exception
     */
    public static function getVacancyFolder(User $user, int $vacancy_id): string
    {
        $path = self::getUserFolder($user) . '/vacancy_' . $vacancy_id;

        return self::create($path);
    }

    /**
     * @param string $path
     * @return string
     * @throws Exception
     */
    private static function create(string $path): string
    {
        if (YiiFileHelper::createDirectory($path)) {
            return $path;
        }

        throw new RuntimeException(sprintf('Directory "%s" was not created', $path));
    }
}