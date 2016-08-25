<?php

namespace App\Lib\DsManager\Models;

use App\Lib\DsManager\Models\Common\Person;

/**
 * Class Player
 * @package App\Lib\DsManager\Models
 */
class Player extends Person
{
	/**
	 * @var
	 */
	public $role;

	/**
	 * @var
	 */
	public $val;

	/**
	 * @return array
	 */
	public function toArray()
	{
		$result = parent::toArray();
		$result["role"] = $this->role;
		$result['val'] = $this->getVal();
		$result['wageReq'] = $this->getWage();

		return $result;
	}

	/**
	 * @return float|int
	 */
	private function calculateVal()
	{
		$val = $this->priceOnSkill();
		$val = $val * (1 + $this->onAgeModifier());
		$val += rand(1, 3);
		$val -= rand(1, 3);
		$val += $this->onRoleModifier();
		$val += $this->spareChange();
		if ($val < 0) $val = $val * -1;
		$val = round($val, 2);
		return $val;
	}

	/**
	 * @return float|int
	 */
	public function getWage()
	{
		if ($this->wageReq == null) {
			$wage = round($this->getVal() / 10.0, 2);
			$wage += $this->spareChange();
			if ($wage < 0) $wage = $wage * -1;
			$this->wageReq = round($wage, 2);
		}
		return $this->wageReq;

	}

	/**
	 * @return float|int
	 */
	public function getVal()
	{
		if ($this->val === null) {
			$this->val = $this->calculateVal();
		}
		return $this->val;
	}

	/**
	 * @return float
	 */
	private function priceOnSkill()
	{
		if ($this->skillAvg > 98) return 130.0;
		if ($this->skillAvg > 90) return 80.0;
		if ($this->skillAvg > 80) return 50.0;
		if ($this->skillAvg > 76) return 20.0;
		if ($this->skillAvg > 70) return 10.0;
		if ($this->skillAvg > 60) return 5.0;
		if ($this->skillAvg > 50) return 2.0;
		return 0.5;

	}

	/**
	 * @return float
	 */
	private function onAgeModifier()
	{
		if ($this->age > 32) return -0.5;
		if ($this->age > 30) return -0.2;
		if ($this->age > 28) return -0.1;
		if ($this->age > 26) return 0.1;
		if ($this->age > 22) return 0.2;
		if ($this->age > 20) return 0.3;
		return 0.5;
	}

	/**
	 * @return int
	 */
	private function onRoleModifier()
	{
		$result = 0;
		if ($this->role == "CS") {
			$result += rand(0, 4);
		} else if ($this->role == "LS") {
			$result += rand(0, 2);
		} else if ($this->role == "RS") {
			$result += rand(0, 2);
		} else if ($this->role == "CM") {
			$result += rand(0, 3);
		} else if ($this->role == "CD") {
			$result += rand(0, 2);
		}

		return $result;
	}
}