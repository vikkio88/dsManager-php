<?php

namespace App\Lib\DsManager\Models;


/**
 * Class MatchResult
 * @package App\Lib\DsManager\Models
 */
class MatchResult
{
	private $goalHome;
	private $goalAway;
	private $homeTeam;
	private $awayTeam;

	/**
	 * MatchResult constructor.
	 * @param $goalHome
	 * @param $goalAway
	 * @param Team $home
	 * @param Team $away
	 */
	public function __construct($goalHome, $goalAway, Team $home, Team $away)
	{
		$this->goalHome = $goalHome;
		$this->goalAway = $goalAway;
		//$this->homeTeam = $home;
		//$this->awayTeam = $away;
	}

	/**
	 * @return array
	 */
	public function toArray()
	{
		$result = [];
		$result["goalHome"] = $this->goalHome;
		$result["goalAway"] = $this->goalAway;
		return $result;
	}

}