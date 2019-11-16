<?php

namespace common\src\helpers;

use RuntimeException;
use Yii;
use yii\base\Exception;
use yii\helpers\FileHelper as YiiFileHelper;
use yii\helpers\Url;

class FileHelper
{
    /**
     * @param int $userId
     * @return string
     * @throws Exception
     */
    public static function getUserFolder(int $userId): string
    {
        $path = Yii::getAlias('@webroot/') . self::getUserRelativeFolder($userId);

        return self::create($path);
    }

    /**
     * @param int $userId
     * @param int $vacancyId
     * @return string
     * @throws Exception
     */
    public static function getVacancyFolder(int $userId, int $vacancyId): string
    {
        $path = Yii::getAlias('@webroot/') . self::getVacancyRelativeFolder($userId, $vacancyId);

        return self::create($path);
    }

    /**
     * @param int $userId
     * @param int $vacancyId
     * @return string
     */
    public static function getVacancyUrl(int $userId, int $vacancyId): string
    {
        return Url::to('@web/') . self::getVacancyRelativeFolder($userId, $vacancyId);
    }

    /**
     * @param int $userId
     * @return string
     * @throws Exception
     */
    public static function getDocumentFolder(int $userId): string
    {
        $path = Yii::getAlias('@webroot/') . self::getDocumentRelativeFolder($userId);

        return self::create($path);
    }

    /**
     * @param int $userId
     * @param string $filename
     * @return string
     */
    public static function getDocumentUrl(int $userId, string $filename): string
    {
        return Url::to('@web/') . self::getDocumentRelativeFolder($userId) . '/' . $filename;
    }

    public static function prepareDocumentFileName(string $baseName, string $extension): string
    {
        return self::normalizeFileName($baseName) . '.' . $extension;
    }

    /**
     * @param string $name
     * @return string
     */
    public static function normalizeFileName(string $name): string
    {
        $result = preg_replace('/\s+/', '_', $name);
        $result = preg_replace('/\W/', '', $result);

        return $result;
    }

    /**
     * @param string $path
     * @return string
     * @throws Exception
     */
    protected static function create(string $path): string
    {
        if (YiiFileHelper::createDirectory($path)) {
            return $path;
        }

        throw new RuntimeException(sprintf('Directory "%s" was not created', $path));
    }

    /**
     * @param int $userId
     * @return string
     */
    protected static function getUserRelativeFolder(int $userId): string
    {
        return 'user/' . $userId;
    }

    /**
     * @param int $userId
     * @param int $vacancyId
     * @return string
     */
    protected static function getVacancyRelativeFolder(int $userId, int $vacancyId): string
    {
        return self::getUserRelativeFolder($userId) . '/vacancy_' . $vacancyId;
    }

    /**
     * @param int $userId
     * @return string
     */
    protected static function getDocumentRelativeFolder(int $userId): string
    {
        return self::getUserRelativeFolder($userId) . '/documents';
    }
}