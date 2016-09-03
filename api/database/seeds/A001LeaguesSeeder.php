<?php


use App\Lib\DsManager\Helpers\LeagueFixtureGenerator;
use App\Lib\DsManager\Models\Orm\League;
use App\Lib\DsManager\Models\Orm\LeagueRound;
use App\Lib\DsManager\Models\Orm\Match;
use App\Lib\DsManager\Models\Orm\Team;

class A001LeaguesSeeder
{
    function run()
    {
        $leagues = [
            'friendly' => 16,
            'europa league' => 8
        ];
        $teams = Team::all()->toArray();
        foreach ($leagues as $league => $teamsNum) {

            $teamCopy = $teams;
            $league = League::create(
                [
                    'name' => $league,
                    'teams' => $teamsNum
                ]
            );

            //Create Rounds
            shuffle($teamCopy);
            $teamCopy = array_splice($teamCopy, 0, $teamsNum);
            $rounds = LeagueFixtureGenerator::generate($teamCopy);
            foreach ($rounds as $i => $round) {

                $leagueRound = LeagueRound::create(
                    [
                        'league_id' => $league->id,
                        'day' => $i + 1
                    ]
                );

                foreach ($round as $match) {
                    $newMatch = Match::create(
                        [
                            'home_team_id' => $match['home_team_id'],
                            'away_team_id' => $match['away_team_id'],
                            'league_round_id' => $leagueRound->id
                        ]
                    );
                }
            }
        }
    }
}