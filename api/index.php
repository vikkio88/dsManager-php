<?php


require_once("vendor/autoload.php");


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

$api->get('/players', function ($request, $response, $args) {
    $json = json_encode(Player::all());
    return Responder::getJsonResponse($json, $response);
});


$api->get('/players/{id}', function ($request, $response, $args) {
    return Responder::getJsonResponse(
        Player::findOrFail($args['id']),
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
        Player::with('matches','goals')->where(
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

$api->get('/matches', function ($request, $response, $args) {
    return Responder::getJsonResponse(
        \App\Lib\DsManager\Models\Orm\Match::with(
            'homeTeam',
            'awayTeam'
        )->get(),
        $response
    );
});

$api->post('/matches', function ($request, $response, $args) {
    $json = $request->getBody();
    $json = json_decode($json, true);
    return Responder::getJsonResponse(
        \App\Lib\DsManager\Models\Orm\Match::create(
            $json
        ),
        $response
    );
});

$api->get('/matches/{id}', function ($request, $response, $args) {
    return Responder::getJsonResponse(
        \App\Lib\DsManager\Models\Orm\Match::complete()
            ->where(
                [
                    'id' => $args['id']
                ]
            )->first(),
        $response
    );
});

$api->get('/matches/{id}/result', function ($request, $response, $args) {
    $result = \App\Lib\DsManager\Models\Orm\MatchResult::complete()
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
    $result = \App\Lib\DsManager\Models\Orm\MatchResult::complete()
        ->where(
            [
                'id' => $args['id']
            ]
        )->first();

    if (!empty($result) && !$result->simulated) {
        //simulate match
        $match = \App\Lib\DsManager\Models\Match::fromArray(
            \App\Lib\DsManager\Models\Orm\Match::complete()
                ->where(
                    [
                        'id' => $args['id']
                    ]
                )->first()->toArray()
        );
        $matchResult = $match->simulate()->toArray();
        $result = \App\Lib\DsManager\Models\Orm\MatchResult::where(
            [
                'id' => $args['id']
            ]
        )->update(
            \App\Lib\DsManager\Models\Orm\MatchResult::resolveAttributes(
                $matchResult,
                $args['id']
            )
        );
        if ($result === 1) {
            $result = \App\Lib\DsManager\Models\Orm\MatchResult::complete()
                ->where(
                    [
                        'id' => $args['id']
                    ]
                )->first();
        }

    }
    return Responder::getJsonResponse(
        $result,
        $response
    );
});
$api->run();