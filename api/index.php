<?php
require_once("../vendor/autoload.php");
use \App\Lib\DsManager\Models\Orm\Player;
use \App\Lib\DsManager\Models\Orm\Team;
use \App\Lib\DsManager\Models\Orm\Coach;

$api = new \Slim\Slim();

$api->response->headers->set('Content-Type', 'application/json');

$api->get('/ping', function () {
    echo json_encode(
        [
            "status" => "service up",
            "message" => "in a bottle",
            "config" => \App\Lib\Helpers\Config::get("config1.stuff")
        ]
    );
});

$api->get('/players', function () {
    echo json_encode(Player::all()->toArray(),JSON_NUMERIC_CHECK);
});

$api->get('/players/:id', function ($id) {
    echo json_encode(Player::findOrFail($id)->toArray(),JSON_NUMERIC_CHECK);
});

$api->get('/coaches', function () {
    echo json_encode(Coach::all()->toArray(),JSON_NUMERIC_CHECK);
});

$api->get('/coaches/:id', function ($id) {
    echo json_encode((Coach::findOrFail($id)->toArray()),JSON_NUMERIC_CHECK);
});

$api->get('/teams', function () {
    echo json_encode(Team::all()->toArray(),JSON_NUMERIC_CHECK);
});

$api->get('/teams/:teamId', function ($teamId) {
    echo json_encode(
        Team::with(
            [
                'roster',
                'coach'
            ])->where('id', '=', $teamId)->get()->toArray(),JSON_NUMERIC_CHECK
    );
});

$api->get('/teams/:teamId/players', function ($teamId) {
    echo json_encode(Team::with('roster')->where('id', '=', $teamId)->get()->toArray());
});

$api->get('/teams/:teamId/players/:playerId', function ($teamId, $playerId) {
    echo json_encode(
        Player::where(
            [
                'id' => $playerId,
                'team_id' => $teamId
            ]
        )->get()->toArray(),JSON_NUMERIC_CHECK
    );
});

$api->get('/teams/:teamId/coach', function ($teamId) {
    echo json_encode(Team::with('coach')->where('id', '=', $teamId)->get()->toArray(),JSON_NUMERIC_CHECK);
});


$api->run();