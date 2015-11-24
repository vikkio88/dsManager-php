<?php


/**
 * Class ModelsTest
 */
class ModelsTest extends \PHPUnit_Framework_TestCase
{


	/**
	 * @group Player
	 */
	public function testGetRandomPlayer()
	{
		$rndF = new \App\Lib\DsManager\Helpers\RandomFiller();
		$player = $rndF->getPlayer();
		var_dump($player->toArray());
	}

	/**
	 * @group Coach
	 */
	public function testGetRandomCoach()
	{
		$rndF = new \App\Lib\DsManager\Helpers\RandomFiller();
		$coach = $rndF->getCoach();
		var_dump($coach->toArray());
	}

	/**
	 * @group Coaches
	 */
	public function testGetRandomCoaches()
	{
		foreach (\App\Lib\Helpers\Config::get('generic.localesSmall', 'api/') as $nat) {
			$rndF = new \App\Lib\DsManager\Helpers\RandomFiller($nat);
			$coach = $rndF->getCoach();
			var_dump($coach->toArray());
		}
	}

	/**
	 * @group Players
	 */
	public function testGetRandomPlayers()
	{
		foreach (\App\Lib\Helpers\Config::get('generic.localesSmall', 'api/') as $nat) {
			$rndF = new \App\Lib\DsManager\Helpers\RandomFiller($nat);
			$player = $rndF->getPlayer();
			var_dump($player->toArray());
		}
	}

	/**
	 * @group Team
	 */
	public function testGetRandomTeam()
	{
		$rndF = new \App\Lib\DsManager\Helpers\RandomFiller("it_IT");
		$team = $rndF->getTeam();

		//var_dump($team->toArray());
		echo "\n" . $team->name . " avg:";
		echo $team->getAvgSkillTeam();

		echo "\n Adding player:";
		$player = $rndF->getPlayer();
		var_dump($player->toArray());
		$team->roster[] = $player;
		echo "\n new avg: ";
		echo $team->getAvgSkillTeam();

	}

}
