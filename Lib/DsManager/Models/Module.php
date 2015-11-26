<?php

namespace App\Lib\DsManager\Models;


/**
 * Class Module
 * @package App\Lib\DsManager\Models
 */
use App\Lib\Helpers\Config;

/**
 * Class Module
 * @package App\Lib\DsManager\Models
 */
class Module
{
	/**
	 * @var
	 */
	private $moduleCode;
	/**
	 * @var
	 */
	private $configuration;

	/**
	 * @param $module
	 */
	public function __construct($module)
	{
		$this->moduleCode = $module;
		$this->configuration = Config::get("modules.modules", "api/")[$module];
		if ($this->configuration == null) throw new \InvalidArgumentException("Not a valid Module supplied");
	}

	/**
	 *
	 */
	public function isOffensive()
	{
		return ($this->configuration["character"] === 1);
	}

	/**
	 *
	 */
	public function isBalanced()
	{
		return ($this->configuration["character"] === 2);
	}

	/**
	 *
	 */
	public function isDefensive()
	{
		return ($this->configuration["character"] === 4);
	}

	/**
	 * @return string
	 */
	function __toString()
	{
		return "" . $this->moduleCode;
	}


	/**
	 * @param Team $team
	 * @return bool
	 */
	public function isApplicable(Team $team)
	{
		$roles = $this->getRoleNeeded();
		$playersForRole = $team->playersPerRoleArray();
		foreach ($roles as $role => $numbP) {
			if (!(isset($playersForRole[$role]) && $playersForRole[$role] >= $numbP)) {
				return false;
			}
		}
		return true;
	}


	/**
	 * @param bool $complete
	 * @return array
	 */
	public function getRoleNeeded($complete = false)
	{
		$rolesNeeded = [];
		$roles = \App\Lib\Helpers\Config::get('modules.roles', "api/");
		$rolesKeys = array_keys($roles);
		foreach ($this->configuration["roles"] as $index => $playNum) {
			if ($playNum != 0 || $complete)
				$rolesNeeded[$rolesKeys[$index]] = $playNum;
		}

		return $rolesNeeded;
	}


}