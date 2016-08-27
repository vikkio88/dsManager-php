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
        $modules = \App\Lib\Helpers\Config::get('modules.modules');
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
        $modules = \App\Lib\Helpers\Config::get('modules.modules');
        $this->assertNotEmpty($modules);
        $roles = \App\Lib\Helpers\Config::get('modules.roles');
        $rolesKeys = array_keys($roles);

        foreach ($modules as $key => $module) {
            $this->assertNotEmpty($module["roles"]);
            foreach ($module["roles"] as $index => $playNum) {
                if ($playNum != 0) {
                    $this->assertGreaterThan(0, $playNum);
                    $this->assertNotNull($roles[$rolesKeys[$index]]["description"]);
                }
            }
        }
    }

    /**
     * @group rand
     *
     */
    public function testRandomizer()
    {
        $yes = 0;
        $no = 0;
        for ($i = 1; $i <= 100; $i++) {
            if (\App\Lib\DsManager\Helpers\Randomizer::boolOnPercentage(20)) {
                $yes++;
            } else {
                $no++;
            }
        }
        $this->assertNotEmpty($yes);
        $this->assertNotEmpty($no);
        $this->assertGreaterThan($yes, $no);
    }

    /**
     * @group randFiller
     *
     */
    public function testRandomFiller()
    {
        $rndF = new \App\Lib\DsManager\Helpers\RandomFiller();
        for ($i = 1; $i <= 10; $i++) {
            $this->assertNotEmpty($rndF->getLocale());
        }
    }

}
