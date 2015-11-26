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
		echo $team->getAvgSkill();

		echo "\n Adding player:";
		$player = $rndF->getPlayer();
		var_dump($player->toArray());
		$team->roster[] = $player;
		echo "\n new avg: ";
		echo $team->getAvgSkill();
		echo "\n age avg: ";
		echo $team->getAvgAge();

	}

	/**
	 * @group Teams
	 */
	public function testGetRandomTeams()
	{
		$rndF = new \App\Lib\DsManager\Helpers\RandomFiller("es_ES");

		for ($i = 1; $i <= 20; $i++) {
			echo "\n\n-------------";
			$team = $rndF->getTeam();
			echo "\n team: " . $team->name;
			echo "\n skill avg: ";
			echo $team->getAvgSkill();
			echo "\n age avg: ";
			echo $team->getAvgAge();
		}
	}

	/**
	 * @group Match
	 */
	public function testGetRandomMatch()
	{
		for ($i = 1; $i <= 30; $i++) {
			$rndF = new \App\Lib\DsManager\Helpers\RandomFiller("it_IT");
			$spanish = $rndF->getTeam();
			$rndF = new \App\Lib\DsManager\Helpers\RandomFiller("it_IT");
			$italian = $rndF->getTeam();

			echo "\n" . $italian->name . "(" . $italian->getAvgSkill() . ") - " . $spanish->name . "(" . $spanish->getAvgSkill() . ") ...... ";
			$result = (new \App\Lib\DsManager\Models\Match($italian, $spanish))->simulate()->toArray();
			echo $result['goalHome'] . " - " . $result['goalAway'];
			echo "\n\n";
		}

	}

	/**
	 * @group Module
	 */
	public function testModule()
	{
		$rndF = new \App\Lib\DsManager\Helpers\RandomFiller("it_IT");
		$team = $rndF->getTeam();

		$modules = \App\Lib\Helpers\Config::get("modules.modules", "api/");
		$modules = array_keys($modules);
		foreach ($modules as $mod) {
			$module = new \App\Lib\DsManager\Models\Module($mod);
			echo "\n------------\n\n" . $module;
			echo "\nD: " . $module->isDefensive();
			echo "\nB: " . $module->isBalanced();
			echo "\nO: " . $module->isOffensive();
			echo "\n";
			print_r($module->getRoleNeeded());
			echo "\napplicable? ";
			if($module->isApplicableToTeam($team)){
				echo " yes";
			}else{
				echo " no";
			}
		}
		echo "\n";
		print_r($team->playersPerRoleArray());
	}

}
