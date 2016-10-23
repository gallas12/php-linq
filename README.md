# php-linq
Linq technology in php language.

### class Linq
Base class that performs queries over the collections of objects and over the array.

**List of methods**
* from() - set primary source
* first() - return first item from collection
* last() - return last item from collection
* select($key = null, $key2 = null) - return result. You can use callable as first param
* count() - return length of collection
* take($offset, $length = null) - return first x items || return interval
* skip($offset) - skip x items a and return other data
* where($condition) - returns only elements that match a given condition
* reverse() - reverse collection
* orderBy($column, $desc = false) - sort. desc = descending. defalt asc = ascending
* distinct() - return unique items
* takeWhile($requirement) - combination = where(condition) + select()
* union($array) - union in sql
* groupBy($key) - Group data
* innerJoin($array) - return only elements that combine both fields
* leftJoin($array) - the first collection will list all entries, even those which do not connect with other collections
* on($condition) - Condition for join two collections
* in($filter) - Accepts an array of values which elements must acquire
* notIn($filter) - negation of "in" method
 * onlyKeys($keys) - filtering data by key
* row_to_column($main_node) - split by a specific key. This key becomes a major hub

**testing data**
```php
protected $students = array(
    array("name" => "Milan", "surname" => "Gallas", "age" => 20, "Job" => "php Programátor"),
    array("name" => "Amdrea", "surname" => "Novotná", "age" => 17, "Job" => "java Programátor"),
    array("name" => "Honza", "surname" => "Pulkert", "age" => 27, "Job" => "c# Programátor"),
    array("name" => "Nikola", "surname" => "Světnická", "age" => 23, "Job" => "php Programátor"),
    array("name" => "Nikola", "surname" => "Světnická", "age" => 23, "Job" => "php Programátor"),
    array("name" => "Petr", "surname" => "Grůdl", "age" => 31, "Job" => "java Programátor"),
);

protected $sports = array(
    array("userName" => "Milan", "sport" => "šachy", "active" => true),
    array("userName" => "Milan", "sport" => "karate", "active" => false),
    array("userName" => "Honza", "sport" => "box", "active" => true),
    array("userName" => "Honza", "sport" => "fotbal", "active" => false),
    array("userName" => "Milan", "sport" => "hokej", "active" => true),
    array("userName" => "Petr", "sport" => "tenis", "active" => true)
);
```

**example of use**
```php
//init base linq class
$linq = \Linq\LinqFactory::createLinq();

//filtering data - select only users who are older than 23
$linq
	->from($userData)
	->where(function($item){
		if($item["age"] > 23) return $item;
	})

//clasic select
var_dump($linq->select());
//select data with function
var_dump(
		$linq->select(function($person){
			$person["age"]*=2;
			return $person;
		})
	);
//or
var_dump(
		$linq->select(function($user){
			//return $user["name"]  //you can try = return string
			return array("userName" => $user["name"]); //return array
		})
	);

//short select = less typing :D
var_dump( $linq->select("age") );  echo '<br>';
var_dump( $linq->select("name", "age") ); echo '<br>';
//$linq->select("name", "age") =>
var_dump(
	$linq->select(function($user){
		return array($user["name"] => $user["age"]);
	})
);



//full use with join method and groupBy
$linq
	->from($userData)
	//->innerJoin($sportData)
	->leftJoin($sportData)
	->on(function($user, $sport){
		return ($user["name"] == $sport["userName"]);
	})
	->groupBy("Job")
	->select()
```


### class JsonLinq
The class takes data source in JSON format. Returns array.

**testing data**
```php
$userJsonData = json_encode($userData);
$sportJsonData = json_encode($sportData);
```

**example of use**
```php
$linq = \Linq\LinqFactory::createJsonLinq();

	echo '<pre>'; var_dump(
		$linq
			->from($userJsonData)
			->takeWhile(function($user){
				return ($user["Job"] === "php Programátor" && $user["age"] > 20);
			})
	);
```


### class XmlLinq
The class takes data source in JSON format. Returns array.

> The "from" method accept string or SimpleXmlElement.
> If out choose xml in string, so you will work with array.
> If you choose xml in SimlpeXmlElement object, so you will work with collection of std objects.


**testing data**
```php
$sportXml =
'<sports>
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

//users
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
```


**example of use**
```php
    //first example. Source is string
	echo '<pre>';
	var_dump(
		\Linq\LinqFactory::createXmlLinq()
			->from($userXml)
			->leftJoin($sportXml)
			->on(function($user, $sport){
				return ($user["name"] == $sport["userName"]);
			})
			->select()
	);


	//second example group by and reverse - source is string
	echo "<pre>";
	var_dump(
		\Linq\LinqFactory::createXmlLinq()->from($userXml)->groupBy("Job", "name")->reverse()->select();
	);
	echo "</pre>";



	//third examlple - source is simpleXmlElement. use condition on collection of objects and sort by orderBy function descending
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

```