<?php
	/**
	 * Created by PhpStorm.
	 * User: Milan Gallas
	 * Date: 6.4.2016
	 * Time: 8:57
	 */

	namespace Linq;

	use Linq\Factory\JoinFactory;
	use Linq\Helper\LeftJoinHelper;

	/**
	 * Class Linq
	 *
	 * easy and fast tranform, filter, sort
	 *
	 * @package lib\utils\linq
	 */
	class Linq
	{
		/** @var JoinFactory  */
		protected $joinFactory;

		/**
		 * Linq constructor.
		 *
		 * @param JoinFactory $joinFactory
		 */
		public function __construct(JoinFactory $joinFactory)
		{
			$this->joinFactory = $joinFactory;
		}

		/**
		 * @var Array primary source
		 */
		protected $array;

		/**
		 * @var Array secondary source from join methods
		 */
		protected $secondaryArray;

		/**
		 * @var string type of join.
		 */
		protected $joinType;

		/**
		 * set primary source
		 *
		 * @param $array
		 * @return $this
		 */
		public function from($array)
		{
			$this->array = $array;

			return $this;
		}

		/**
		 * return first item from collection
		 *
		 * @return mixed
		 */
		public function first()
		{
			return $this->array[0];
		}

		/**
		 * return last item from collection
		 *
		 * @return mixed
		 */
		public function last()
		{
			return $this->array[count($this->array) - 1];
		}

		/**
		 * return result. You can use callable as first param
		 *
		 * @param $key       - name of key || callable
		 * @param null $key2 - ame of value. You can use as fetchPairs in dibi
		 *                   sloupec
		 * @return array
		 */
		public function select($key = null, $key2 = null)
		{
			//call without parameters
			if (!$key) {
				return $this->array;
			}
			//first param is callable
			if(is_callable($key)){
				$array = $this->array;
				return array_map($key, $array);
			}

			else {
				//both params used
				if ($key2) {
					$firstKey = array_keys($this->array)[0];
					if (is_object($this->array[$firstKey])) {
						return array_map(function ($item) {
							return (object)$item;
						}, $this->array_column_to_object($key2, $key));
					}
						return array_column($this->array, $key2, $key);
				}
				//only first param
				else {
					$firstKey = array_keys($this->array)[0];
					if (is_object($this->array[$firstKey])) {
						return array_map(function ($item) {
							return (object)$item;
						}, $this->array_column_to_object($key, $key2));
					}
					return array_column($this->array, $key, null);
				}
			}
		}

		/**
		 * use for collection of objects
		 *
		 * @param type $key2
		 * @param type $key
		 * @return type
		 */
		protected function array_column_to_object($key2, $key)
		{
			return array_column(array_map(function ($item) {
				return (array)$item;
			}, $this->array), $key2, $key);
		}

		/**
		 * return collection´s length
		 *
		 * @return int
		 */
		public function count()
		{
			return count($this->array);
		}

		/**
		 * return first x items || return interval
		 * @example take(10, 20) -> BETWEEN 11 AND 21 (in sql language)
		 *
		 * @param $offset
		 * @param null $length
		 * @return array
		 */
		public function take($offset, $length = null)
		{
			if (!$length) {
				return array_slice($this->array, 0, $offset);
			}

			return array_slice($this->array, $offset, $length);
		}

		/**
		 * skip x items a and return other data
		 *
		 * @param $offset
		 * @return Zdroj
		 */
		public function skip($offset)
		{
			$array = array();
			$i = 0;
			foreach ($this->array as $key => $value) {
				if ($i >= $offset) {
					$array[$key] = $value;
				}
				$i++;
			}

			return $array;
		}

		/**
		 * returns only elements that match a given condition
		 *
		 * @param $condition callable
		 * @return $this
		 * @throws \Exception
		 */
		public function where(callable $condition)
		{
			if(!is_callable($condition)){
				throw new \Exception("parameter condition must by callable");
			}
			$this->array = array_filter($this->array, $condition);
			return $this;
		}

		/**
		 * reverse collection
		 *
		 * @return $this
		 */
		public function reverse()
		{
			$this->array = array_reverse($this->array, true);

			return $this;
		}

		/**
		 * sort
		 *
		 * @param $column
		 * @param bool $desc
		 * @return $this
		 */
		public function orderBy($column, $desc = false)
		{
			uasort($this->array, function ($a, $b) use ($column) {
				if (is_array($a)) {
					if ($a[$column] == $b[$column]) {
						return 0;
					}

					return ($a[$column] < $b[$column]) ? -1 : 1;
				} else {
					if ($a->$column == $b->$column) {
						return 0;
					}

					return ($a->$column < $b->$column) ? -1 : 1;
				}
			});
			if ($desc) {
				$this->reverse();
			}

			return $this;
		}

		/**
		 * return unique items
		 *
		 * @return $this
		 */
		public function distinct()
		{
			$this->array = array_unique($this->array, SORT_REGULAR);

			return $this;
		}

		/**
		 * combination = where(condition) + select()
		 *
		 * @param $requirement
		 * @return array
		 */
		public function takeWhile($requirement)
		{
			$this->where($requirement);

			return $this->select();
		}


		/**
		 * union in sql
		 *
		 * @param $array
		 * @return $this
		 */
		public function union($array)
		{
			$this->array = array_merge($this->array, $array);

			return $this;
		}

		/**
		 * group by
		 * @example - goupBy("age")
		 * @example - groupBy("name", "age")
		 * @example - groupBy("country", "distrinct", "city", "street")
		 *
		 * @param $key
		 * @return $this
		 */
		public function groupBy($key)
		{
			$params = array_reverse(func_get_args());

			$params[] = $this->array;
			$this->array = call_user_func_array(array($this, 'array_group_by'), array_reverse($params));

			return $this;
		}

		/**
		 * @param array $array
		 * @param $key
		 * @return array|null
		 */
		protected function array_group_by(array $array, $key)
		{
			if (!is_string($key) && !is_int($key) && !is_float($key) && !is_callable($key)) {
				trigger_error('array_group_by(): The key should be a string, an integer, or a callback', E_USER_ERROR);

				return null;
			}


			$func = (is_callable($key) ? $key : null);
			$_key = $key;

			// Load the new array, splitting by the target key
			$grouped = [];
			foreach ($array as $value) {
				if (is_callable($func)) {
					$key = call_user_func($func, $value);
				} else {
					$key = $value[$_key];
				}

				$grouped[$key][] = $value;
			}

			// Recursively build a nested grouping if more parameters are supplied
			// Each grouped array value is grouped according to the next sequential key
			if (func_num_args() > 2) {
				$args = func_get_args();

				foreach ($grouped as $key => $value) {
					$params = array_merge([$value], array_slice($args, 2, func_num_args()));
					$grouped[$key] = call_user_func_array(array($this, 'array_group_by'), $params);
				}
			}

			return $grouped;
		}

		/**
		 * return only elements that combine both fields
		 *
		 * @param $array
		 * @return $this
		 */
		public function innerJoin($array)
		{
			$this->secondaryArray = $array;
			$this->joinType = "inner";

			return $this;
		}

		/**
		 * the first collection will list all entries, even those which do not connect with other collections
		 *
		 * @param $array
		 * @return $this
		 */
		public function leftJoin($array)
		{
			$this->secondaryArray = $array;
			$this->joinType = "left";

			return $this;
		}

		/**
		 * Condition for join two collections
		 *
		 * @param $condition
		 * @return $this
		 * @throws \Exception
		 */
		public function on($condition)
		{
			if(!$this->secondaryArray){
				throw new \Exception("You must call innerJoin or leftJoin method!");
			}
			$this->array = $this->joinFactory
				->getJoinObject($this->joinType)
				->setFirstSource($this->array)
				->setSecondarySource($this->secondaryArray)
				->join($condition);
			return $this;
		}

		/**
		 * Accepts an array of values which elements must acquire
		 *
		 * @param type $filter
		 * @return $this
		 */
		public function in($filter)
		{
			$count = count($this->array);
			for ($i = 0; $i < $count; $i++) {
				if (is_array($this->array[$i])) {
					if (!in_array($this->array[$i], $filter, true)) {
						unset($this->array[$i]);
					}
				} else {
					if (!in_array($this->array[$i], $filter)) {
						unset($this->array[$i]);
					}
				}
			}

			return $this;
		}

		/**
		 * negation of "in" method
		 *
		 * @param type $filter
		 * @return $this
		 */
		public function notIn($filter)
		{
			$count = count($this->array);
			for ($i = 0; $i < $count; $i++) {
				if (is_array($this->array[$i])) {
					if (in_array($this->array[$i], $filter, true)) {
						unset($this->array[$i]);
					}
				} else {
					if (in_array($this->array[$i], $filter)) {
						unset($this->array[$i]);
					}
				}
			}

			return $this;
		}

		/**
		 * filtering data by key
		 *
		 * @param type $keys
		 * @return $this
		 */
		public function onlyKeys($keys)
		{
			$count = count($this->array);
			for ($i = 0; $i < $count; $i++) {
				if (is_array($this->array[$i])) {
					$this->array[$i] = array_intersect_key($this->array[$i], array_flip($keys));
				} else {
					$this->array[$i] = (object)array_intersect_key((array)$this->array[$i], array_flip($keys));
				}
			}

			return $this;
		}

		/**
		 * @param $main_node
		 * @return $this
		 */
		public function rowToColumn($main_node){
			$new_array = array();
			foreach($this->array as $key => $value){
				//echo $key.'<br>';
				$column_array = array();
				foreach($value as $column_key => $column_value){
					if($column_key != $main_node){
						$column_array[$column_key] = $column_value;
					}else{
						$main_key = $column_value;
					}
				}
				$new_array[$main_key] = $column_array;

			}

			$this->array = $new_array;

			return $this;
		}
	}