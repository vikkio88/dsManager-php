<?php


namespace App\Lib\DsManager\Helpers;


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
	 * @return Player
	 */
	public function getPlayer()
	{
		$player = new Player;
		$player->name = $this->faker->firstNameMale . " " . $this->faker->lastName;
		$player->role = $this->getRole();
		$player->nationality = $this->locale;
		$player->age = $this->faker->numberBetween(16, 38);
		$player->skillAvg = $this->faker->numberBetween(40, 100);

		return $player;
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

	public function getTeam()
	{
		$players = [];
		for ($i = 0; $i < 12; $i++) {
			$players[] = $this->getPlayer();
		}
		return $players;
	}

}