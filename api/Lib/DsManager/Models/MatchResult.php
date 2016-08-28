<?php

namespace App\Lib\DsManager\Models;

use App\Lib\DsManager\Helpers\Randomizer;
use App\Lib\DsManager\Models\Common\DsManagerModel;
use App\Lib\Helpers\Config;


/**
 * Class MatchResult
 * @package App\Lib\DsManager\Models
 */
class MatchResult extends DsManagerModel
{
    /**
     * @var
     */
    private $goalHome;
    /**
     * @var
     */
    private $goalAway;
    /**
     * @var Team
     */
    private $homeTeam;
    /**
     * @var Team
     */
    private $awayTeam;

    /**
     * MatchResult constructor.
     * @param $goalHome
     * @param $goalAway
     * @param Team $home
     * @param Team $away
     */
    public function __construct($goalHome, $goalAway, Team $home, Team $away)
    {
        $this->goalHome = $goalHome;
        $this->goalAway = $goalAway;
        $this->homeTeam = $home;
        $this->awayTeam = $away;
    }

    /**
     * @return array
     */
    public function getWinnerLoser()
    {
        $isDraw = false;
        $winner = null;
        $loser = null;
        if ($this->goalAway == $this->goalHome) {
            $isDraw = true;
            $winner = $this->homeTeam;
            $loser = $this->awayTeam;
        } else if ($this->goalHome > $this->goalAway) {
            $winner = $this->homeTeam;
            $loser = $this->awayTeam;
        } else {
            $winner = $this->awayTeam;
            $loser = $this->homeTeam;
        }

        return [
            'is_draw' => $isDraw,
            'winner' => $this->cleanTeam($winner->toArray()),
            'loser' => $this->cleanTeam($loser->toArray())
        ];
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [];
        $result["goal_home"] = $this->goalHome;
        $result["goal_away"] = $this->goalAway;
        $result['info'] = $this->getWinnerLoser();
        $result['info']['scorers'] = $this->getScorers();
        $result['simulated'] = true;
        return $result;
    }

    /**
     * @param array $team
     * @return array
     */
    private function cleanTeam(array $team)
    {
        $fieldsToClean = [
            'coach',
            'roster',
        ];

        foreach ($fieldsToClean as $field) {
            if (array_key_exists($field, $team)) {
                unset($team[$field]);
            }
        }
        return $team;
    }

    /**
     * @return array
     */
    private function getScorers()
    {
        $scorers = [
            'home' => [],
            'away' => []
        ];
        for ($i = 0; $i < $this->goalHome; $i++) {
            $scorers['home'][] = $this->pickAScorer($this->homeTeam);
        }
        for ($i = 0; $i < $this->goalAway; $i++) {
            $scorers['away'][] = $this->pickAScorer($this->awayTeam);
        }
        return $scorers;
    }

    /**
     * @param Team $team
     * @return Player
     */
    private function pickAScorer(Team $team)
    {
        $player = null;
        if (Randomizer::boolOnPercentage(70)) {
            $roles = Config::get('modules.roles');
            $forwards = array_splice($roles, count($roles) / 2);
            $pos = array_rand($forwards);
            unset($forwards[$pos]);
            $player = $team->getBestPlayerForRole($pos);
            while (empty($player)) {
                if (!empty($forwards)) {
                    $pos = array_rand($forwards);
                    unset($forwards[$pos]);
                    $player = $team->getBestPlayerForRole($pos);
                } else {
                    $player = $team->roster[array_rand($team->roster)];
                }
            }
        } else {
            $player = $team->roster[array_rand($team->roster)];
        }
        return $player;
    }

}