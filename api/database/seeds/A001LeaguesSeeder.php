<?php


class A001LeaguesSeeder
{
    function run()
    {
        $leagues = [
            'friendly' => 5,
            'europa league' => 2
        ];

        foreach ($leagues as $league => $dayMatches) {
            $league = \App\Lib\DsManager\Models\Orm\League::create(
                [
                    'name' => $league
                ]
            );

            for ($i = 1; $i <= $dayMatches; $i++) {
                \App\Lib\DsManager\Models\Orm\MatchDay::create(
                    [
                        'league_id' => $league->id,
                        'day' => $i
                    ]
                );
            }
        }
    }
}