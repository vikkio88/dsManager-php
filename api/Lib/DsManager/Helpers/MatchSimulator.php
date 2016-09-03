<?php


namespace App\Lib\DsManager\Helpers;


use App\Lib\DsManager\Models\Orm\Match;
use App\Lib\DsManager\Models\Orm\Match as MatchOrm;
use App\Lib\DsManager\Models\Orm\MatchResult;

/**
 * Class MatchSimulator
 * @package App\Lib\DsManager\Helpers
 */
class MatchSimulator
{
    public static function simulateRound($roundId)
    {
        $matches = Match::where(
            [
                'league_round_id' => $roundId
            ]
        )->get();
        $result = [];
        foreach ($matches as $match) {
            $result[] = self::simulateSimpleResult($match->id)->toArray();
        }
        return json_encode($result);
    }

    /**
     * @param $matchId
     * @return mixed
     */
    public static function simulateCompleteResult($matchId)
    {
        $result = MatchResult::complete()->where(
            [
                'id' => $matchId
            ]
        )->first();

        if (!empty($result)
            && !$result->simulated
            && self::simulate($matchId) === 1
        ) {
            $result = MatchResult::complete()
                ->where(
                    [
                        'id' => $matchId
                    ]
                )->first();
        }

        return $result;
    }

    public
    static function simulateSimpleResult($matchId)
    {
        $result = MatchResult::teams()->where(
            [
                'id' => $matchId
            ]
        )->first();

        if (!empty($result)
            && !$result->simulated
            && self::simulate($matchId) === 1
        ) {
            $result = MatchResult::teams()
                ->where(
                    [
                        'id' => $matchId
                    ]
                )->first();
        }
        return $result;
    }

    private
    static function simulate($matchId)
    {
        $match = \App\Lib\DsManager\Models\Match::fromArray(
            MatchOrm::complete()
                ->where(
                    [
                        'id' => $matchId
                    ]
                )->first()->toArray()
        );
        $matchResult = $match->simulate()->toArray();
        $result = MatchResult::where(
            [
                'id' => $matchId
            ]
        )->update(
            MatchResult::resolveAttributes(
                $matchResult,
                $matchId
            )
        );
        return $result;
    }
}