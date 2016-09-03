<?php


/**
 * Class Helpers
 */
class Helpers extends \PHPUnit_Framework_TestCase
{


    /**
     * @group Helpers
     * @group FixtureGenerator
     * @group generatefixture
     */
    public function testFixtureGenerator()
    {
        $teams = \App\Lib\DsManager\Models\Orm\Team::all();
        $rounds = \App\Lib\DsManager\Helpers\LeagueFixtureGenerator::generate(
            $teams->toArray()
        );
        //Number of rounds
        $this->assertCount($teams->count() - 1, $rounds);
        //Matches for each round
        foreach ($rounds as $round) {
            $this->assertCount($teams->count() / 2, $round);
        }
    }

    /**
     * @group Helpers
     * @group MatchSimulator
     */
    public function testMatchSimulator()
    {
        $match = \App\Lib\DsManager\Models\Orm\Match::where(
            [
                'simulated' => false
            ]
        )->get()->random(1);
        $this->assertNotEmpty($match);
        $result = \App\Lib\DsManager\Helpers\MatchSimulator::simulateCompleteResult($match->id);
        $this->assertNotEmpty($result);
        $match = \App\Lib\DsManager\Models\Orm\Match::where(
            [
                'id' => $match->id,
                'simulated' => true
            ]
        )->first();
        $this->assertNotEmpty($match);
    }

    /**
     * @group Helpers
     * @group RoundSimulator
     */
    public function testRoundSimulator()
    {
        $match = \App\Lib\DsManager\Models\Orm\Match::where(
            [
                'simulated' => false
            ]
        )->whereNotNull(
            'league_round_id'
        )->get()->random(1);
        $this->assertNotEmpty($match);
        $result = \App\Lib\DsManager\Helpers\MatchSimulator::simulateRound($match->league_round_id);
        $this->assertNotEmpty($result);
        $match = \App\Lib\DsManager\Models\Orm\Match::where(
            [
                'id' => $match->id,
                'simulated' => true
            ]
        )->first();
        $this->assertNotEmpty($match);
    }

}
