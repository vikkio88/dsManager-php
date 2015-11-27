<?php

namespace App\Lib\DsManager\Models;

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
	 * @var
	 */
	public $nationality;

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

	/**
	 * @param $role
	 * @return array
	 */
	public function getPlayersForRole($role)
	{
		$result = [];
		foreach ($this->roster as $player) {
			if ($player->role == $role) {
				$result[] = $player;
			}
		}
		return $result;
	}

	/**
	 * @param $role
	 * @return null
	 */
	public function getBestPlayerForRole($role)
	{
		$players = $this->getPlayersForRole($role);
		$maxSkill = 0;
		$index = -1;
		$i = 0;
		foreach ($players as $player) {
			if ($player->skillAvg > $maxSkill) {
				$index = $i;
				$maxSkill = $player->skillAvg;
			}
			$i++;
		}

		if ($index === -1) {
			return null;
		}
		return $players[$index];
	}

	/**
	 * @return array
	 */
	public function playersPerRoleArray()
	{
		$result = [];
		foreach ($this->roster as $player) {
			$result[$player->role] = isset($result[$player->role]) ? $result[$player->role] + 1 : 1;
		}
		return $result;
	}
}