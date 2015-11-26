<?php


namespace App\Lib\DsManager\Helpers;


use App\Lib\DsManager\Models\Coach;
use App\Lib\DsManager\Models\Player;
use App\Lib\DsManager\Models\Team;
use App\Lib\Helpers\Config;

/**
 * Class RandomFiller
 * @package App\Lib\DsManager\Helpers
 */
class RandomFiller
{
	/**
	 * @var \Faker\Generator
	 */
	protected $faker;

	/**
	 * @var string
	 */
	protected $locale;

	/**
	 * RandomFiller constructor.
	 */
	public function __construct($locale = "it_IT")
	{
		$this->locale = $locale;
		$this->faker = \Faker\Factory::create($locale);
	}


	/**
	 * @param null $forcedRole
	 * @return Player
	 */
	public function getPlayer($forcedRole = null)
	{
		$player = new Player;
		$player->name = $this->faker->firstNameMale;
		$player->surname = $this->faker->lastName;
		$player->role = $forcedRole == null ? $this->getRole() : $forcedRole;
		$player->nationality = $this->locale;
		$player->age = rand(16, 38);
		$player->skillAvg = rand(40, 100);

		return $player;
	}


	/**
	 * @return Coach
	 */
	public function getCoach()
	{
		$coach = new Coach;
		$coach->name = $this->faker->firstNameMale;
		$coach->surname = $this->faker->lastName;
		$coach->favouriteModule = $this->getModule();
		$coach->nationality = $this->locale;
		$coach->age = rand(33, 68);
		$coach->skillAvg = rand(40, 100);

		return $coach;
	}

	/**
	 * @return mixed
	 */
	public function getRole()
	{
		$roles = array_keys(Config::get('modules.roles', 'api/'));
		shuffle($roles);
		return $roles[0];
	}

	/**
	 * @return mixed
	 */
	public function getModule()
	{
		$modules = array_keys(Config::get('modules.modules', 'api/'));
		shuffle($modules);
		return $modules[0];
	}


	/**
	 * @return Team
	 */
	public function getTeam()
	{
		$team = new Team;
		$team->name = $this->faker->city;
		$team->coach = $this->getCoach();
		$players = [];
		for ($i = 0; $i < 11; $i++) {
			$players[] = $this->getPlayer();
		}

		//Adding some forced role
		$players[] = $this->getPlayer("GK");
		$players[] = $this->getPlayer("CD");
		$players[] = $this->getPlayer("CD");
		$players[] = $this->getPlayer("CM");
		//

		$team->roster = $players;

		return $team;
	}

}