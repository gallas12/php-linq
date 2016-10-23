<?php
	/**
	 * Created by PhpStorm.
	 * User: Milan Gallas
	 * Date: 23.10.2016
	 * Time: 0:06
	 */

	//autoload
	require "../vendor/autoload.php";
	/**
	 * Source data
	 */
	require 'data/user.php';
	require 'data/sport.php';


	//first example
	/*echo '<pre>';
	var_dump(
		\Linq\LinqFactory::createXmlLinq()
			->from($userXml)
			->leftJoin($sportXml)
			->on(function($user, $sport){
				return ($user["name"] == $sport["userName"]);
			})
			->select()
	);*/


	//second example group by and reverse
	/*echo "<pre>";
	var_dump(
		\Linq\LinqFactory::createXmlLinq()->from($userXml)->groupBy("Job", "name")->reverse()->select();
	);
	echo "</pre>";*/



	//third examlple - simple xml element. use condition on collection of objects and sort by orderBy function descending
	$xmlElemetn = new SimpleXMLElement($userXml);
	echo '<pre>';
	var_dump(
		\Linq\LinqFactory::createXmlLinq()
			->from($xmlElemetn)
			->where(function($user){
				return (strlen($user->name) > 5);
			})
			->orderBy("age", true)
			->select()
	);
