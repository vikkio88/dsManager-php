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
        echo "\n";
        print_r($arrayPl);
        echo "trying orm";
        $playerO = \App\Lib\DsManager\Models\Orm\Player::create($arrayPl);
        print_r($playerO->toArray());

        $newPlayer = \App\Lib\DsManager\Models\Player::fromArray($playerO->toArray());
        print_r($newPlayer->toArray());
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
        echo "\n";
        print_r($arrayPl);
        echo "trying orm";
        $coachO = \App\Lib\DsManager\Models\Orm\Coach::create($arrayPl);
        print_r($coachO->toArray());

        $newCoach = \App\Lib\DsManager\Models\Coach::fromArray($coachO->toArray());
        print_r($newCoach->toArray());
    }
}
