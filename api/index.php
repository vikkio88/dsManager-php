<?php


require_once("vendor/autoload.php");


use App\Lib\DsManager\Helpers\MatchSimulator;
use App\Lib\DsManager\Models\Orm\League;
use App\Lib\DsManager\Models\Orm\LeagueRound;
use App\Lib\DsManager\Models\Orm\Match;
use App\Lib\DsManager\Models\Orm\MatchResult;
use \App\Lib\Helpers\Responder;
use \App\Lib\DsManager\Models\Orm\Player;
use \App\Lib\DsManager\Models\Orm\Team;
use \App\Lib\DsManager\Models\Orm\Coach;

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$c = new \Slim\Container($configuration);
$api = new \Slim\App($c);

$api->get('/ping', function ($request, $response, $args) {
    $jsonResp = json_encode(
        [
            "status" => "service up",
            "message" => "in a bottle"
        ]
    );
    return Responder::getJsonResponse($jsonResp, $response);
});

$api->get('/statistics', function ($request, $response, $args) {
    return Responder::getJsonResponse(
        json_encode([
            'players' => Player::getBest(),
            'teams' => Team::getBest()
        ]),
        $response
    );
});

$api->get('/coaches', function ($request, $response, $args) {
    return Responder::getJsonResponse(
        Coach::all(),
        $response
    );
});

$api->get('/teams', function ($request, $response, $args) {
    return Responder::getJsonResponse(
        Team::all(),
        $response
    );
});

$api->get('/teams/{id}', function ($request, $response, $args) {
    return Responder::getJsonResponse(
        Team::complete()
            ->where(
                [
                    'id' => $args['id']
                ]
            )->get(),
        $response
    );
});

$api->get('/teams/{id}/players', function ($request, $response, $args) {
    return Responder::getJsonResponse(
        Team::with(
            'roster'
        )->where(
            [
                'id' => $args['id']
            ]
        )->get(),
        $response
    );
});

$api->get('/teams/{id}/players/{playerId}', function ($request, $response, $args) {
    return Responder::getJsonResponse(
        Player::statistics()->where(
            [
                'id' => $args['playerId'],
                'team_id' => $args['id']
            ]
        )->get(),
        $response
    );
});

$api->get('/teams/{id}/coach', function ($request, $response, $args) {
    return Responder::getJsonResponse(
        Team::with(
            'coach'
        )->where(
            [
                'id' => $args['id']
            ]
        )->get(),
        $response
    );
});

$api->get('/leagues', function ($request, $response, $args) {
    return Responder::getJsonResponse(
        League::all(),
        $response
    );
});

$api->get('/leagues/{id}', function ($request, $response, $args) {
    return Responder::getJsonResponse(
        League::with('rounds')
            ->where(
                [
                    'id' => $args['id']
                ]
            )->first(),
        $response
    );
});

$api->get('/leagues/{id}/rounds/{roundId}', function ($request, $response, $args) {
    return Responder::getJsonResponse(
        LeagueRound::complete()
            ->where(
                [
                    'id' => $args['roundId'],
                ]
            )->first(),
        $response
    );
});

$api->put('/leagues/{id}/rounds/{roundId}/simulate', function ($request, $response, $args) {
    return Responder::getJsonResponse(
        MatchSimulator::simulateRound(
            $args['roundId']
        ),
        $response
    );
});

$api->get('/matches', function ($request, $response, $args) {
    return Responder::getJsonResponse(
        Match::teams()->get(),
        $response
    );
});

$api->post('/matches', function ($request, $response, $args) {
    $json = $request->getBody();
    $json = json_decode($json, true);
    return Responder::getJsonResponse(
        Match::create(
            $json
        ),
        $response
    );
});

$api->get('/matches/{id}', function ($request, $response, $args) {
    return Responder::getJsonResponse(
        Match::complete()
            ->where(
                [
                    'id' => $args['id']
                ]
            )->first(),
        $response
    );
});

$api->get('/matches/{id}/result', function ($request, $response, $args) {
    $result = MatchResult::complete()
        ->where(
            [
                'id' => $args['id']
            ]
        )->first();

    return Responder::getJsonResponse(
        $result,
        $response
    );
});

$api->put('/matches/{id}/simulate', function ($request, $response, $args) {
    return Responder::getJsonResponse(
        MatchSimulator::simulateCompleteResult(
            $args['id']
        ),
        $response
    );
});
$api->run();