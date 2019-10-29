<?php

namespace common\src\helpers;

use common\models\User;
use Throwable;
use Yii;
use yii\db\Exception;
use yii\log\Logger;
use yii\web\IdentityInterface;

class Helper
{
    /**
     * @return null|IdentityInterface|User
     */
    public static function getUserIdentity(): ?IdentityInterface
    {
        try {
            return Yii::$app->getUser()->getIdentity();
        } catch (Throwable $e) {
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
        }

        return null;
    }

    /**
     * @param User $user
     * @return int
     */
    public static function getUnreadMessageCount(User $user): int
    {
        $id = (int)$user->getId();

        $sql = "SELECT * FROM message m
                JOIN chat c ON m.chat_id = c.id
                WHERE (c.adjunct_user_id = $id OR c.institution_user_id = $id) AND m.author_user_id <> $id AND m.`read` = 0";

        try {
            $r = Yii::$app->db->createCommand($sql)->query()->count();
        } catch (Exception $e) {
            Yii::getLogger()->log('Query execution failed. ' . $e->getMessage(), Logger::LEVEL_ERROR);
            $r = 0;
        }

        return $r;
    }

}