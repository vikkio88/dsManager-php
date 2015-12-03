<?php
require_once("../vendor/autoload.php");
use \App\Lib\Helpers\JsonResponse;
use \App\Lib\DsManager\Models\Orm\Player;
use \App\Lib\DsManager\Models\Orm\Team;
use \App\Lib\DsManager\Models\Orm\Coach;

$api = new \Slim\Slim();

$api->response->headers->set('Content-Type', 'application/json');

$api->get('/ping', function () {
	echo JsonResponse::fromArray(
		[
			"status" => "service up",
			"message" => "in a bottle",
			"config" => \App\Lib\Helpers\Config::get("config1.stuff")
		]
	);
});

$api->get('/players', function () {
	echo JsonResponse::fromArray(
		Player::all()->toArray()
	);
});

$api->get('/players/:id', function ($id) {
	echo JsonResponse::fromArray(
		Player::findOrFail($id)->toArray()
	);
});

$api->get('/coaches', function () {
	echo JsonResponse::fromArray(
		Coach::all()->toArray()
	);
});

$api->get('/coaches/:id', function ($id) {
	echo JsonResponse::fromArray(
		Coach::findOrFail($id)->toArray()
	);
});

$api->get('/teams', function () {
	echo JsonResponse::fromArray(
		Team::all()->toArray()
	);
});

$api->get('/teams/:teamId', function ($teamId) {
	echo JsonResponse::fromArray(
		Team::with(
			[
				'roster',
				'coach'
			])->where('id', '=', $teamId)->get()->toArray()
	);
});

$api->get('/teams/:teamId/players', function ($teamId) {
	echo JsonResponse::fromArray(
		Team::with(
			'roster'
		)->where('id', '=', $teamId)->get()->toArray()
	);
});

$api->get('/teams/:teamId/players/:playerId', function ($teamId, $playerId) {
	echo JsonResponse::fromArray(
		Player::where(
			[
				'id' => $playerId,
				'team_id' => $teamId
			]
		)->get()->toArray()
	);
});

$api->get('/teams/:teamId/coach', function ($teamId) {
	echo JsonResponse::fromArray(
		Team::with(
			'coach'
		)->where('id', '=', $teamId)->get()->toArray()
	);
});


$api->run();