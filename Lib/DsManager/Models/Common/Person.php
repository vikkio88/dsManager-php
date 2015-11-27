<?php


namespace App\Lib\DsManager\Models\Common;


use App\Lib\DsManager\Helpers\Randomizer;

abstract class Person extends DsManagerModel
{
	/**
	 * @var
	 */
	public $name;
	/**
	 * @var
	 */
	public $surname;
	/**
	 * @var
	 */
	public $nationality;
	/**
	 * @var
	 */
	public $age;
	/**
	 * @var
	 */
	public $skillAvg;
	/**
	 * @var
	 */
	public $wageReq;

	/**
	 * @return array
	 */
	public function toArray()
	{
		$result = [];
		$result['name'] = $this->name;
		$result['surname'] = $this->surname;
		$result['nationality'] = $this->nationality;
		$result['age'] = $this->age;
		$result['skillAvg'] = $this->skillAvg;
		return $result;
	}

	/**
	 * @return float|int
	 */
	protected function spareChange()
	{
		if (Randomizer::boolOnPercentage(50)) {
			return (rand(1, 5) / 10.0);
		} else {
			return (-1) * (rand(1, 5) / 10.0);
		}
	}
}