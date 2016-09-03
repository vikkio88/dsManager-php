<?php


namespace App\Lib\DsManager\Helpers;


use App\Lib\DsManager\Models\Orm\Match;
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
            $result[] = self::simulate($match->id, false)->toArray();
        }
        return $result;
    }

    /**
     * @param $matchId
     * @param bool $completeResult
     * @return mixed
     */
    public static function simulate($matchId, $completeResult = true)
    {
        $result = MatchResult::complete()
            ->where(
                [
                    'id' => $matchId
                ]
            )->first();
        if (!empty($result) && !$result->simulated) {
            //simulate match
            $match = \App\Lib\DsManager\Models\Match::fromArray(
                \App\Lib\DsManager\Models\Orm\Match::complete()
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
            if ($result === 1) {
                if ($completeResult) {
                    $result = MatchResult::complete()
                        ->where(
                            [
                                'id' => $matchId
                            ]
                        )->first();
                } else {
                    $result = MatchResult::teams()
                        ->where(
                            [
                                'id' => $matchId
                            ]
                        )->first();
                }
            }

        }
        return $result;
    }
}