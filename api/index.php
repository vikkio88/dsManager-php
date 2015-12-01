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
	echo Player::all()->toJson();
});

$api->get('/coaches', function () {
	echo Coach::all()->toJson();
});

$api->get('/teams', function () {
	echo Team::all()->toJson();
});

$api->get('/teams/:teamId', function ($teamId) {
	echo Team::with(
		[
			'roster',
			'coach'
		])->where('id', '=', $teamId)->get()->toJson();
});

$api->get('/teams/:teamId/players', function ($teamId) {
	echo Team::with('roster')->where('id', '=', $teamId)->get()->toJson();
});

$api->get('/teams/:teamId/coach', function ($teamId) {
	echo Team::with('coach')->where('id', '=', $teamId)->get()->toJson();
});


$api->run();