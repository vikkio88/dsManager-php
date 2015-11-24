<?php


/**
 * Class ModuleConfigurationTest
 */
class ModuleConfigurationTest extends \PHPUnit_Framework_TestCase
{


	/**
	 * @group Modules
	 * @group config
	 */
	public function testAllTheModulesGot11Players()
	{
		$modules = \App\Lib\Helpers\Config::get('modules.modules', "api/");
		$this->assertNotEmpty($modules);
		foreach ($modules as $key => $module) {
			$this->assertNotEmpty($module["roles"]);
			$count = 0;
			foreach ($module["roles"] as $roleNum) {
				$count += $roleNum;
			}
			$this->assertTrue(11 === $count, "Not correct Players for $key");
		}
	}

	/**
	 * @group Roles
	 * @group config
	 */
	public function testCorrectDisplayModuleDescriptionRole()
	{
		$modules = \App\Lib\Helpers\Config::get('modules.modules', "api/");
		$this->assertNotEmpty($modules);
		$roles = \App\Lib\Helpers\Config::get('modules.roles', "api/");
		$rolesKeys = array_keys($roles);

		foreach ($modules as $key => $module) {
			echo "\nto play $key\n";
			$this->assertNotEmpty($module["roles"]);
			foreach ($module["roles"] as $index => $playNum) {
				if($playNum != 0)
					echo $playNum . " " . $roles[$rolesKeys[$index]]["description"] . " ";
			}
		}
	}

}
