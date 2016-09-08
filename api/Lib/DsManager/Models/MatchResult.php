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
        $winner = $this->homeTeam;
        $loser = $this->awayTeam;
        if ($this->goalAway == $this->goalHome) {
            $isDraw = true;
        } else if ($this->goalHome < $this->goalAway) {
            $winner = $this->awayTeam;
            $loser = $this->homeTeam;
        }
        return [
            'is_draw' => $isDraw,
            'winner_id' => $winner->id,
            'loser_id' => $loser->id
        ];
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [];
        $result['home_team_id'] = $this->homeTeam->id;
        $result['away_team_id'] = $this->awayTeam->id;
        $result['goal_home'] = $this->goalHome;
        $result['goal_away'] = $this->goalAway;
        $result['info'] = $this->getWinnerLoser();
        $result['info']['scorers'] = $this->getScorers();
        $result['simulated'] = true;
        return $result;
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