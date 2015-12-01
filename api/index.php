<?php
require_once("../vendor/autoload.php");


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
	echo \App\Lib\DsManager\Models\Orm\Player::all()->toJson();
});

$api->get('/coaches', function () {
	echo \App\Lib\DsManager\Models\Orm\Coach::all()->toJson();
});

$api->get('/teams', function () {
	echo \App\Lib\DsManager\Models\Orm\Team::all()->toJson();
});



$api->run();