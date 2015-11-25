<?php

namespace App\Lib\DsManager\Models;

/**
 * Class Team
 * @package App\Lib\DsManager\Models
 */
/**
 * Class Team
 * @package App\Lib\DsManager\Models
 */
class Team
{
	/**
	 * @var
	 */
	public $name;
	/**
	 * @var
	 */
	public $coach;
	/**
	 * @var
	 */
	public $roster;

	/**
	 * @return array
	 */
	public function toArray()
	{
		$result = [];
		$result['name'] = $this->name;
		$result['coach'] = $this->coach->toArray();
		$roster = [];
		foreach ($this->roster as $player) {
			$roster[] = $player->toArray();
		}
		$result['roster'] = $roster;
		return $result;
	}

	/**
	 * @return string
	 */
	public function getAvgSkill()
	{
		$c = 0;
		$tot = 0;
		foreach ($this->roster as $player) {
			$tot += $player->skillAvg;
			$c++;
		}

		return bcdiv($tot, $c, 2);
	}

	/**
	 * @return string
	 */
	public function getAvgAge()
	{
		$c = 0;
		$tot = 0;
		foreach ($this->roster as $player) {
			$tot += $player->age;
			$c++;
		}

		return bcdiv($tot, $c, 2);
	}
}