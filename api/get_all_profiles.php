<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

if($_SERVER['REQUEST_METHOD'] == "GET"){
	spl_autoload_register(function ($clase) {
		require_once('../model/'.$clase . '.php');
	});

$user = new User();
$list = $user->api_list();
$data = json_encode($list);
echo $data;

}
