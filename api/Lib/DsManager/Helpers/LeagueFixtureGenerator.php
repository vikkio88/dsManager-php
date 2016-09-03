<?php


namespace App\Lib\DsManager\Helpers;

class LeagueFixtureGenerator
{
    public static function generate(array $teams)
    {
        $numTeams = count($teams);
        $numRounds = ($numTeams - 1);
        $halfSize = $numTeams / 2;

        $away = array_splice($teams, $halfSize);
        $home = $teams;
        $rounds = [];
        for ($i = 0; $i < $numRounds ; $i++) {
            for ($j = 0; $j < count($home); $j++) {
                $rounds[$i][$j]["home_team_id"] = $home[$j]['id'];
                $rounds[$i][$j]["away_team_id"] = $away[$j]['id'];
            }
            if (count($home) + count($away) - 1 > 2) {
                array_unshift($away, array_shift(array_splice($home, 1, 1)));
                array_push($home, array_pop($away));
            }
        }
        return $rounds;
    }
}