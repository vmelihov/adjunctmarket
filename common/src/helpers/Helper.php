<?php

namespace common\src\helpers;

use common\models\User;
use Throwable;
use Yii;
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
}