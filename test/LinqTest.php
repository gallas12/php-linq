<?php
	/**
	 * Created by PhpStorm.
	 * User: Milan Gallas
	 * Date: 22.10.2016
	 * Time: 15:50
	 */

	//autoload
	require "../vendor/autoload.php";
	/**
	 * Source data
	 */
	require 'data/user.php';
	require 'data/sport.php';

	$linq = \Linq\LinqFactory::createLinq();

	/**
	 * Part 1 - source for select examples
	 */
/*	$linq
		->from($userData)
		->where(function($item){
			if($item["age"] > 23) return $item;
		});*/


	/**
	 * clasic callback select functions
	 */
	/*
	echo '<pre>'; var_dump($linq->select());
	echo '<pre>';
	var_dump(
		$linq->select(function($person){
			$person["age"]*=2;
			return $person;
		})
	);
	echo '<pre>';
	var_dump(
		$linq->select(function($user){
			//return $user["name"]  //you can try = return string
			return array("userName" => $user["name"]); //return array
		})
	);
*/
	/**
	 * short select - you must uncomment from method on the top
	 */
	/*
	echo '<pre>';
	var_dump( $linq->select("age") );  echo '<br>';
	var_dump( $linq->select("name", "age") ); echo '<br>';

	//alternativa posledního zápisu
	var_dump(
		$linq->select(function($user){
			return array($user["name"] => $user["age"]);
		})
	);*/

	/**
	 * part 2 joins and groupBy
	 */
	echo '<pre>';var_dump(
		$linq
			->from($userData)
			//->innerJoin($sportData)
			->leftJoin($sportData)
			->on(function($user, $sport){
				return ($user["name"] == $sport["userName"]);
			})
			->groupBy("Job")
			->select()
	);


