<?php


namespace App\Lib\DsManager\Models\Common;


abstract class Person
{
	public $name;
	public $surname;
	public $nationality;
	public $age;
	public $skillAvg;

	public function toArray(){
		$result = [];
		$result['name'] = $this->name;
		$result['surname'] = $this->surname;
		$result['nationality'] = $this->nationality;
		$result['age'] = $this->age;
		$result['skillAvg'] = $this->skillAvg;

		return $result;
	}
}