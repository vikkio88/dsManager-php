<?php


/**
 * Class PlayersTest
 */
class PlayersTest extends \PHPUnit_Framework_TestCase
{


	/**
	 * @group Players
	 * @group config
	 */
	public function testGetRandomPlayer()
	{
		$rndF = new \App\Lib\DsManager\Helpers\RandomFiller();
		$player = $rndF->getPlayer();
		var_dump($player->attributesToArray());
	}

	/**
	 * @group PlayersTeam
	 * @group config
	 */
	public function testGetRandomTeam()
	{
		$rndF = new \App\Lib\DsManager\Helpers\RandomFiller("es_ES");
		$team = $rndF->getTeam();
		foreach ($team as $player) {
			var_dump($player->attributesToarray());
		}

	}

}
