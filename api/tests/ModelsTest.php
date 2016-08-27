<?php


/**
 * Class ModelsTest
 */
class ModelsTest extends \PHPUnit_Framework_TestCase
{


    /**
     * @group Player
     */
    public function testGetRandomPlayer()
    {
        $rndF = new \App\Lib\DsManager\Helpers\RandomFiller();
        $player = $rndF->getPlayer(null, $rndF->getLocale());
        $array = $player->toArray();
        $this->assertNotEmpty($array);

        $newPlayer = \App\Lib\DsManager\Models\Player::fromArray($array);
        $this->assertNotEmpty($newPlayer->toArray());
    }

    /**
     * @group Coach
     */
    public function testGetRandomCoach()
    {
        $rndF = new \App\Lib\DsManager\Helpers\RandomFiller();
        $coach = $rndF->getCoach();
        $this->assertNotEmpty($coach->toArray());
    }

    /**
     * @group Coaches
     */
    public function testGetRandomCoaches()
    {
        foreach (\App\Lib\Helpers\Config::get('generic.localesSmall') as $nat) {
            $rndF = new \App\Lib\DsManager\Helpers\RandomFiller($nat);
            $coach = $rndF->getCoach();
            $this->assertNotEmpty($coach->toArray());
        }
    }

    /**
     * @group Players
     */
    public function testGetRandomPlayers()
    {
        foreach (\App\Lib\Helpers\Config::get('generic.localesSmall') as $nat) {
            $rndF = new \App\Lib\DsManager\Helpers\RandomFiller($nat);
            $player = $rndF->getPlayer();
            $this->assertNotEmpty($player->toArray());
        }
    }

    /**
     * @group Team
     */
    public function testGetRandomTeam()
    {
        $rndF = new \App\Lib\DsManager\Helpers\RandomFiller("it_IT");
        $team = $rndF->getTeam();
        $this->assertNotEmpty($team);
        $this->assertNotEmpty($team->name);
        $this->assertNotEmpty($team->getAvgSkill());

        //After Adding a player
        $player = $rndF->getPlayer();
        $this->assertNotEmpty($player->toArray());
        $team->roster[] = $player;
        $this->assertNotEmpty($team->getAvgSkill());
        $this->assertNotEmpty($team->getAvgAge());

        $this->assertNotEmpty($team->coach->toArray());

        $teamArray = $team->toArray();
        $this->assertNotEmpty($teamArray);

        $newTeam = \App\Lib\DsManager\Models\Team::fromArray($teamArray);
        $this->assertNotEmpty($newTeam->toArray());

    }

    /**
     * @group Teams
     */
    public function testGetRandomTeams()
    {
        $rndF = new \App\Lib\DsManager\Helpers\RandomFiller("it_IT");

        for ($i = 1; $i <= 20; $i++) {
            $team = $rndF->getTeam();
            $this->assertNotEmpty($team->name);
            $this->assertNotEmpty($team->nationality);
            $this->assertNotEmpty($team->getAvgSkill());
            $this->assertNotEmpty($team->getAvgAge());
        }
    }

    /**
     * @group Match
     */
    public function testGetRandomMatch()
    {
        for ($i = 1; $i <= 30; $i++) {
            $rndF = new \App\Lib\DsManager\Helpers\RandomFiller("it_IT");
            $spanish = $rndF->getTeam();
            $rndF = new \App\Lib\DsManager\Helpers\RandomFiller("it_IT");
            $italian = $rndF->getTeam();
            $this->assertNotEmpty($spanish);
            $this->assertNotEmpty($italian);
            $this->assertNotEmpty($italian->name);
            $this->assertNotEmpty($spanish);
            $this->assertNotEmpty($spanish->name);

            $this->assertNotEmpty($italian->getAvgSkill());
            $this->assertNotEmpty($spanish->getAvgSkill());
            $result = (new \App\Lib\DsManager\Models\Match($italian, $spanish))->simulate()->toArray();
            $this->assertNotEmpty($result);
            $this->assertGreaterThanOrEqual(0, $result['goalHome']);
            $this->assertGreaterThanOrEqual(0, $result['goalAway']);

        }
    }

    /**
     * @group Match
     * @group MatchResult
     * @group matchresultoutput
     */
    public function testMatchFromExistingTeams()
    {
        $teamHome = 1;
        $teamAway = 2;
        $homeOrm = \App\Lib\DsManager\Models\Orm\Team::with('roster', 'coach')->where(['id' => $teamHome])->first();
        $awayOrm = \App\Lib\DsManager\Models\Orm\Team::with('roster', 'coach')->where(['id' => $teamAway])->first();
        $home = \App\Lib\DsManager\Models\Team::fromArray($homeOrm->toArray());
        $away = \App\Lib\DsManager\Models\Team::fromArray($awayOrm->toArray());

        $match = new \App\Lib\DsManager\Models\Match($home, $away);
        $result = $match->simulate()->toArray();
        $this->assertNotEmpty($result);
        $this->assertGreaterThanOrEqual(0, $result['goalAway']);
        $this->assertGreaterThanOrEqual(0, $result['goalHome']);
        if ($result['goalHome'] > 0) {
            $this->assertNotEmpty($result['info']['scorers']['home']);
            foreach ($result['info']['scorers']['home'] as $scorerHome) {
                $this->assertEquals($scorerHome->team_id, $teamHome);
            }
        } else {
            $this->assertEmpty($result['info']['scorers']['home']);
        }
        if ($result['goalAway'] > 0) {
            $this->assertNotEmpty($result['info']['scorers']['away']);
            foreach ($result['info']['scorers']['away'] as $scorerAway) {
                $this->assertEquals($scorerAway->team_id, $teamAway);
            }
        } else {
            $this->assertEmpty($result['info']['scorers']['away']);
        }
        if ($result['goalHome'] == $result['goalAway']) {
            $this->assertTrue($result['info']['isDraw']);
        } else {
            $this->assertFalse($result['info']['isDraw']);
        }
    }

    /**
     * @group Matches
     */
    public function testGetRandomMatchesOneTeam()
    {
        $rndF = new \App\Lib\DsManager\Helpers\RandomFiller("it_IT");
        $myTeam = $rndF->getTeam();
        $win = 0;
        $lost = 0;
        $draw = 0;

        for ($i = 1; $i <= 2; $i++) {

            $randomLocale = \App\Lib\Helpers\Config::get('generic.localesSmall');
            shuffle($randomLocale);
            $randomLocale = $randomLocale[0];

            $rndF = new \App\Lib\DsManager\Helpers\RandomFiller($randomLocale);
            $opponent = $rndF->getTeam();
            $result = (new \App\Lib\DsManager\Models\Match($opponent, $myTeam))->simulate()->toArray();
            $this->assertNotEmpty($result);
            $result = $result['info'];
            if (!$result['isDraw']) {
                if ($result['winner']['name'] == $myTeam->name) {
                    $win++;
                } else {
                    $lost++;
                }
            } else {
                $draw++;
            }
        }
        $this->assertGreaterThanOrEqual(0, $win);
        $this->assertGreaterThanOrEqual(0, $lost);
        $this->assertGreaterThanOrEqual(0, $draw);
    }

    /**
     * @group Module
     */
    public function testModule()
    {
        $rndF = new \App\Lib\DsManager\Helpers\RandomFiller("it_IT");
        $team = $rndF->getTeam();

        $modules = \App\Lib\Helpers\Config::get("modules.modules");
        $modules = array_keys($modules);
        foreach ($modules as $mod) {
            $module = new \App\Lib\DsManager\Models\Module($mod);
            $this->assertNotEmpty($module);
            $this->assertNotNull($module->isDefensive());
            $this->assertNotNull($module->isBalanced());
            $this->assertNotNull($module->isOffensive());
            $this->assertTrue(is_array($module->getRoleNeeded()));
        }
        $this->assertGreaterThan(0, $team->playersPerRoleArray());
    }

}
