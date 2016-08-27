<?php

namespace App\Lib\DsManager\Models;

use App\Lib\DsManager\Helpers\Randomizer;

/**
 * Class Match
 * @package App\Lib\DsManager\Models
 */
class Match
{
    /**
     * @var Team
     */
    private $homeTeam;
    /**
     * @var Team
     */
    private $awayTeam;

    /**
     * Match constructor.
     * @param Team $home
     * @param Team $away
     */
    public function __construct(Team $home, Team $away)
    {
        $this->homeTeam = $home;
        $this->awayTeam = $away;
    }

    /**
     * @return MatchResult
     */
    public function simulate()
    {
        $homePoints = $this->homeTeam->getAvgSkill();
        $awayPoints = $this->awayTeam->getAvgSkill();

        $homePoints += $this->malusModule(
            $this->homeTeam->coach->favouriteModule,
            $this->homeTeam->playersPerRoleArray()
        );
        $awayPoints += $this->malusModule(
            $this->awayTeam->coach->favouriteModule,
            $this->awayTeam->playersPerRoleArray()
        );

        $goalHome = 0;
        $goalAway = 0;

        if (Randomizer::boolOnPercentage(80)) {
            if (($homePoints - $awayPoints) < 0) {
                $goalAway = ($awayPoints - $homePoints) % 6;
                $goalHome += $this->chance();
                $goalAway += $this->chance();
                $goalHome += $this->bonusHome();
            } else {
                $goalHome = ($homePoints - $awayPoints) % 6;
                $goalAway += $this->chance();
                $goalHome += $this->bonusHome();
            }
        } else {
            $goalHome += $this->chance();
            $goalAway += $this->chance();
            $goalHome += $this->bonusHome();
        }
        $goalHome += $this->bonusAge($this->homeTeam);
        $goalAway += $this->bonusAge($this->awayTeam);

        //Bonus on Good GoalKeeper
        $goalies = $this->homeTeam->getBestPlayerForRole("GK");
        $goalAway -= $this->bonusGoalKeeper($goalies);
        $goalies = $this->awayTeam->getBestPlayerForRole("GK");
        $goalHome -= $this->bonusGoalKeeper($goalies);
        //
        $homeModule = new Module($this->homeTeam->coach->favouriteModule);
        $awayModule = new Module($this->awayTeam->coach->favouriteModule);
        if ($homeModule->isOffensive()) {
            $goalHome += Randomizer::boolOnPercentage(50) ? rand(1, 2) : 0;
            $goalAway += Randomizer::boolOnPercentage(20) ? 1 : 0;
        }
        if ($awayModule->isOffensive()) {
            $goalAway += Randomizer::boolOnPercentage(50) ? rand(1, 2) : 0;
            $goalHome += Randomizer::boolOnPercentage(20) ? 1 : 0;
        }
        if ($awayModule->isDefensive()) {
            $goalHome -= Randomizer::boolOnPercentage(50) ? 1 : 0;
        }
        if ($homeModule->isDefensive()) {
            $goalAway -= Randomizer::boolOnPercentage(50) ? 1 : 0;
        }
        $goalHome = $goalHome < 0 ? 0 : $goalHome;
        $goalAway = $goalAway < 0 ? 0 : $goalAway;
        return new MatchResult($goalHome, $goalAway, $this->homeTeam, $this->awayTeam);
    }

    /**
     * @param Team $team
     * @return int
     */
    private function bonusAge(Team $team)
    {
        if ($team->getAvgAge() > 29 || $team->getAvgAge() < 24) {
            return $this->chance();
        }
        return 0;
    }

    /**
     * @param $goalkeeper
     * @return int
     */
    private function bonusGoalKeeper($goalkeeper)
    {
        $skillGoalkeeper = empty($goalkeeper) ? 1 : $goalkeeper->skillAvg;
        return (Randomizer::boolOnPercentage($skillGoalkeeper) ? 1 : 0);
    }

    /**
     * @return int
     */
    private function chance()
    {
        return rand(0, 3);
    }

    /**
     * @return int
     */
    private function bonusHome()
    {
        return Randomizer::boolOnPercentage(66) ? 1 : 0;
    }

    /**
     * @param $moduleString
     * @param $playersRoleArray
     * @return int
     */
    private function malusModule($moduleString, $playersRoleArray)
    {
        $module = new Module($moduleString);
        if ($module->isApplicableToArray($playersRoleArray)) {
            return rand(1, 10);
        } else {
            return (-1) * rand(1, 10);
        }
    }

}