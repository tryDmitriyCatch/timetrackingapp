<?php

declare(strict_types=1);

namespace App\Utils;

/**
 * Class PasswordUtils
 *
 * @package App\Utils
 */
class DatesUtils
{
    /**
     * @param array $results
     * @return int
     */
    public static function getSumOfAllTimeSpent(array $results): int
    {
        $sum = 0;

        foreach ($results as $task) {
            $sum += $task->getTimeSpent();
        }

        return $sum;
    }

    /**
     * @param int $sum
     * @return string
     */
    public static function getHours(int $sum): string
    {
        return date('H', mktime(0, $sum));
    }

    /**
     * @param int $sum
     * @return string
     */
    public static function getMinutes(int $sum): string
    {
        return date('i', mktime(0, $sum));
    }
}
