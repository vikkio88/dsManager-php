<?php

namespace App\Lib\DsManager\Models;

use App\Lib\DsManager\Helpers\Randomizer;

/**
 * Class Match
 * @package App\Lib\DsManager\Models
 */
class Match
{
	private $homeTeam;
	private $awayTeam;

	/**
	 * Match constructor.
	 * @param Team $home
	 * @param Team $away
	 */
	public function __construct(Team $home, Team $away)
	{
		$this->homeTeam = $home;
		$this->awayTeam = $away;
	}

	/**
	 * @return MatchResult
	 */
	public function simulate()
	{
		$homePoints = $this->homeTeam->getAvgSkill();
		$awayPoints = $this->awayTeam->getAvgSkill();

		$goalHome = 0;
		$goalAway = 0;

		if (Randomizer::boolOnPercentage(80)) {

			if (($homePoints - $awayPoints) < 0) {
				$goalAway = ($awayPoints - $homePoints) % 6;
				$goalHome += $this->chance();
				$goalAway += $this->chance();
				$goalHome += $this->bonusHome();
			} else {
				$goalHome = ($homePoints - $awayPoints) % 6;
				$goalAway += $this->chance();
				$goalHome += $this->bonusHome();
			}

		} else {
			$goalHome += $this->chance();
			$goalAway += $this->chance();
			$goalHome += $this->bonusHome();
		}

		$avgAgeHome = $this->homeTeam->getAvgAge();
		$avgAgeAway = $this->awayTeam->getAvgAge();

		if ( $avgAgeHome > 29 ) { $goalHome += $this->bonusHome(); }
		if ( $avgAgeAway > 29 ) { $goalAway += $this->bonusHome(); }

		if ( $avgAgeHome < 24 ) { $goalHome += $this->bonusHome(); }
		if ( $avgAgeAway < 24 ) { $goalAway += $this->bonusHome(); }

		return new MatchResult($goalHome, $goalAway, $this->homeTeam, $this->awayTeam);
	}

	private function chance()
	{
		return rand(0, 3);
	}

	private function bonusHome()
	{
		return Randomizer::boolOnPercentage(66) ? 1 : 0;
	}

}