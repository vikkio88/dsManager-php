<?php


namespace App\Lib\DsManager\Helpers;


use App\Lib\DsManager\Models\Match;
use App\Lib\DsManager\Models\Orm\MatchResult;

/**
 * Class MatchSimulator
 * @package App\Lib\DsManager\Helpers
 */
class MatchSimulator
{

    /**
     * @param $matchId
     * @return mixed
     */
    public static function simulate($matchId)
    {
        $result = MatchResult::complete()
            ->where(
                [
                    'id' => $matchId
                ]
            )->first();

        if (!empty($result) && !$result->simulated) {
            //simulate match
            $match = Match::fromArray(
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
                $result = MatchResult::complete()
                    ->where(
                        [
                            'id' => $matchId
                        ]
                    )->first();
            }

        }

        return $result;
    }
}