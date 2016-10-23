<?php
	$sportData = array(
		array("userName" => "Milan", "sport" => "šachy", "active" => true),
		array("userName" => "Milan", "sport" => "karate", "active" => false),
		array("userName" => "Honza", "sport" => "box", "active" => true),
		array("userName" => "Honza", "sport" => "fotbal", "active" => false),
		array("userName" => "Milan", "sport" => "hokej", "active" => true),
		array("userName" => "Petr", "sport" => "tenis", "active" => true)
	);

	$sportXml = '<sports>
 <sport>
 <userName>Milan</userName>
 <sport>šachy</sport>
 <active>true</active>
 </sport>
 <sport>
 <userName>Milan</userName>
 <sport>karate</sport>
 <active>false</active>
 </sport>
 <sport>
 <userName>Milan</userName>
 <sport>hokej</sport>
 <active>true</active>
 </sport>
 <sport>
 <userName>Honza</userName>
 <sport>box</sport>
 <active>true</active>
 </sport>
 <sport>
 <userName>Honza</userName>
 <sport>fotbal</sport>
 <active>false</active>
 </sport>
 <sport>
 <userName>Petr</userName>
 <sport>tenis</sport>
 <active>true</active>
 </sport>
</sports>';