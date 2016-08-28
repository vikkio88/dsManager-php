<?php


class BMatchesSeeder
{
    function run()
    {
        $teams = \App\Lib\DsManager\Models\Orm\Team::all()->toArray();
        $halfTheTeams = count($teams) / 2;
        $chunks = array_chunk($teams, $halfTheTeams);
        $teamsSlice1 = $chunks[0];
        $teamsSlice2 = $chunks[1];
        for ($i = 0; $i < $halfTheTeams; $i++) {
            \App\Lib\DsManager\Models\Orm\Match::create(
                [
                    'home_team_id' => $teamsSlice1[$i]['id'],
                    'away_team_id' => $teamsSlice2[$i]['id']
                ]
            );
        }
    }
}