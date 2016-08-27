<?php


/**
 * Class OrmModelsTest
 */
class OrmModelsTest extends \PHPUnit_Framework_TestCase
{


    /**
     * @group OrmModels
     * @group PlayerOrm
     */
    public function testPlayerOrmGetSet()
    {
        $rndFiller = new \App\Lib\DsManager\Helpers\RandomFiller();
        $playerM = $rndFiller->getPlayer();
        $arrayPl = $playerM->toArray();
        $playerO = \App\Lib\DsManager\Models\Orm\Player::create($arrayPl);
        $this->assertNotEmpty($playerO);

        $newPlayer = \App\Lib\DsManager\Models\Player::fromArray($playerO->toArray());
        $this->assertNotEmpty($newPlayer);
    }

    /**
     * @group OrmModels
     * @group CoachOrm
     */
    public function testCoachOrmGetSet()
    {
        $rndFiller = new \App\Lib\DsManager\Helpers\RandomFiller();
        $coach = $rndFiller->getCoach();
        $arrayPl = $coach->toArray();
        $coachO = \App\Lib\DsManager\Models\Orm\Coach::create($arrayPl);
        $this->assertNotEmpty($coachO);

        $newCoach = \App\Lib\DsManager\Models\Coach::fromArray($coachO->toArray());
        $this->assertNotEmpty($newCoach);
    }

    /**
     * @group OrmModels
     * @group TeamOrm
     */
    public function testTeamOrm()
    {
        $rndFiller = new \App\Lib\DsManager\Helpers\RandomFiller();
        $team = $rndFiller->getTeam($rndFiller->getLocale());
        $teamArray = $team->toArray();
        $this->assertNotEmpty($team);
        $teamO = \App\Lib\DsManager\Models\Orm\Team::create($teamArray);
        $this->assertNotEmpty($teamArray);
        $this->assertNotEmpty($teamArray['roster']);
        foreach ($teamArray['roster'] as $player) {
            $player['team_id'] = $teamO->id;
            $playerO = \App\Lib\DsManager\Models\Orm\Player::create($player);
            $this->assertNotEmpty($playerO);
        }
        $teamArray['coach']['team_id'] = $teamO->id;
        $coachO = \App\Lib\DsManager\Models\Orm\Coach::create($teamArray['coach']);
        $this->assertNotEmpty($coachO);

        $this->assertNotEmpty(
            \App\Lib\DsManager\Models\Orm\Team::with(
                'roster'
            )->with(
                'coach'
            )->where(
                [
                    'id' => $teamO->id
                ]
            )->get()->toArray()
        );
    }
}
