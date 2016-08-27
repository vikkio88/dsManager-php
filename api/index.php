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
            "message" => "in a bottle",
            "config" => \App\Lib\Helpers\Config::get("config1.stuff")
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
        Team::with(
            'roster',
            'coach'
        )->where(
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
        Player::where(
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

$api->run();