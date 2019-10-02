<?php

namespace common\src\helpers;

use DateTime;
use Exception;

class DateTimeHelper
{
    /**
     * @param $date
     * @return null|int
     * @throws Exception
     */
    public static function getTimeAgo($date): ?int
    {
        if (is_string($date)) {
            try {
                $datetime = new DateTime($date);
            } catch (Exception $e) {
                return null;
            }
        } elseif (is_int($date)) {
            $datetime = new DateTime();
            $datetime->setTimestamp($date);
        } else {
            return null;
        }

        $now = new DateTime();
        $dateDiff = $datetime->diff($now);

        $minutes = $dateDiff->d * 24 * 60;
        $minutes += $dateDiff->h * 60;
        $minutes += $dateDiff->i;

        return $minutes;
    }
}