<?php
	/**
	 * Created by PhpStorm.
	 * User: Milan Gallas
	 * Date: 22.10.2016
	 * Time: 19:00
	 */
	$userData = array(
		array("name" => "Milan", "surname" => "Gallas", "age" => 20, "Job" => "php Programátor"),
		array("name" => "Amdrea", "surname" => "Novotná", "age" => 17, "Job" => "java Programátor"),
		array("name" => "Honza", "surname" => "Pulkert", "age" => 27, "Job" => "c# Programátor"),
		array("name" => "Nikola", "surname" => "Poprachová", "age" => 23, "Job" => "php Programátor"),
		array("name" => "Nikola", "surname" => "Poprachová", "age" => 23, "Job" => "php Programátor"),
		array("name" => "Petr", "surname" => "Grůdl", "age" => 31, "Job" => "java Programátor"),
	);

	$userXml = '
	<students>
 <student>
 <name>Milan</name>
 <surname>Gallas</surname>
 <age>20</age>
 <Job>php Programátor</Job>
 </student>
 <student>
 <name>Amdrea</name>
 <surname>Novotná</surname>
 <age>17</age>
 <Job>Java Programátor</Job>
 </student>
 <student>
 <name>Honza</name>
 <surname>Pulkert</surname>
 <age>27</age>
 <Job>c# Programátor</Job>
 </student>
 <student>
 <name>Nikola</name>
 <surname>Světnická</surname>
 <age>23</age>
 <Job>php Programátor</Job>
 </student>
 <student>
 <name>Nikola</name>
 <surname>Světnická</surname>
 <age>23</age>
 <Job>php Programátor</Job>
 </student>
 <student>
 <name>Petr</name>
 <surname>Grůdl</surname>
 <age>31</age>
 <Job>Java Programátor</Job>
 </student>
</students>
	';