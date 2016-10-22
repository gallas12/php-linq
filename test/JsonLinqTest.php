<?php
	/**
	 * Created by PhpStorm.
	 * User: Milan Gallas
	 * Date: 22.10.2016
	 * Time: 23:37
	 */

//autoload
	require "../vendor/autoload.php";
	/**
	 * Source data
	 */
	require 'data/user.php';
	require 'data/sport.php';
	$userJsonData = json_encode($userData);
	$sportJsonData = json_encode($sportData);

	$linq = \Linq\LinqFactory::createJsonLinq();

	echo '<pre>'; var_dump(
		$linq
			->from($userJsonData)
			->takeWhile(function($user){
				return ($user["Job"] === "php Programátor" && $user["age"] > 20);
			})
	);