<?php


namespace App\Lib\DsManager\Helpers;


/**
 * Class Randomizer
 * @package App\Lib\DsManager\Helpers
 */
class Randomizer
{
    /**
     * @param $percentage
     * @return bool
     */
    public static function boolOnPercentage($percentage)
    {
        return (rand(0, 100) < $percentage);
    }

    /**
     * @param $skill
     * @return int
     */
    public static function voteFromSkill($skill)
    {
        return rand((2 * ($skill - 100) / 25), 10);
    }

}