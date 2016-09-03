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
    /**
     * @param $roundId
     * @return string
     */
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
        $result = self::getCompleteResult($matchId);
        if (!empty($result)
            && !$result->simulated
            && self::simulate($matchId) === 1
        ) {
            $result = self::getCompleteResult($matchId);
        }
        return $result;
    }

    /**
     * @param $matchId
     * @return mixed
     */
    public static function simulateSimpleResult($matchId)
    {
        $result = self::getSimpleResult($matchId);
        if (!empty($result)
            && !$result->simulated
            && self::simulate($matchId) === 1
        ) {
            $result = self::getSimpleResult($matchId);
        }
        return $result;
    }

    /**
     * @param $matchId
     * @return mixed
     */
    private static function simulate($matchId)
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


    /**
     * @param $matchId
     * @return MatchResult
     */
    private static function getCompleteResult($matchId)
    {
        return MatchResult::complete()->where(
            [
                'id' => $matchId
            ]
        )->first();
    }

    /**
     * @param $matchId
     * @return MatchResult
     */
    private static function getSimpleResult($matchId)
    {
        return MatchResult::teams()->where(
            [
                'id' => $matchId
            ]
        )->first();
    }

}