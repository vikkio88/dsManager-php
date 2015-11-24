<?php


/**
 * Class PlayersTest
 */
class PlayersTest extends \PHPUnit_Framework_TestCase
{


	/**
	 * @group Player
	 * @group config
	 */
	public function testGetRandomPlayer()
	{
		$rndF = new \App\Lib\DsManager\Helpers\RandomFiller();
		$player = $rndF->getPlayer();
		var_dump($player->attributesToArray());
	}

	/**
	 * @group Players
	 * @group config
	 */
	public function testGetRandomPlayers()
	{
		foreach (\App\Lib\Helpers\Config::get('generic.localesSmall', 'api/') as $nat) {
			$rndF = new \App\Lib\DsManager\Helpers\RandomFiller($nat);
			$player = $rndF->getPlayer();
			var_dump($player->attributesToArray());
		}
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
