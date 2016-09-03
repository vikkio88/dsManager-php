<?php


class A000TeamsSeeder
{
    function run()
    {
        $teamNumber = 16;
        $rndFiller = new \App\Lib\DsManager\Helpers\RandomFiller();
        for ($i = 1; $i <= $teamNumber; $i++) {
            $team = $rndFiller->getTeam($rndFiller->getLocale());
            $teamArray = $team->toArray();
            $teamO = \App\Lib\DsManager\Models\Orm\Team::create($teamArray);
            foreach ($teamArray['roster'] as $player) {
                $player['team_id'] = $teamO->id;
                \App\Lib\DsManager\Models\Orm\Player::create($player);
            }
            $teamArray['coach']['team_id'] = $teamO->id;
            \App\Lib\DsManager\Models\Orm\Coach::create($teamArray['coach']);
        }
    }
}