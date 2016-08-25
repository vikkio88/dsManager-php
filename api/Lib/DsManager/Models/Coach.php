<?php

namespace App\Lib\DsManager\Models;

use App\Lib\DsManager\Models\Common\Person;


/**
 * Class Coach
 * @package App\Lib\DsManager\Models
 */
class Coach extends Person
{
	/**
	 * @var
	 */
	public $favouriteModule;

	/**
	 * @return array
	 */
	public function toArray()
	{
		$result = parent::toArray();
		$result["favouriteModule"] = $this->favouriteModule;
		$result["wageReq"] = $this->getWage();
		return $result;
	}

	/**
	 * @return float
	 */
	public function getWage()
	{
		if ($this->wageReq == null) {
			$wage = $this->wageOnSkill();
			$wage += $this->spareChange();
			if ($wage < 0) $wage = $wage * (-1);
			$this->wageReq = round($wage, 2);
		}
		return $this->wageReq;
	}

	/**
	 * @return float
	 */
	private function wageOnSkill()
	{
		if ($this->skillAvg > 98) return 5.0;
		if ($this->skillAvg > 90) return 3.5;
		if ($this->skillAvg > 80) return 2.0;
		if ($this->skillAvg > 76) return 1.5;
		if ($this->skillAvg > 70) return 1.0;
		if ($this->skillAvg > 60) return .76;
		if ($this->skillAvg > 50) return .20;
		return 0.5;

	}
}