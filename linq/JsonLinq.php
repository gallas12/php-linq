<?php
	/**
	 * Created by PhpStorm.
	 * User: Milan Gallas
	 * Date: 22.10.2016
	 * Time: 23:32
	 */

	namespace Linq;


	class JsonLinq extends Linq
	{
		/**
		 * load json and transform to array
		 *
		 * @param type $array
		 * @return $this
		 */
		public function from($array)
		{
			$this->array = json_decode($array, true);
			return $this;
		}

		/**
		 * return only elements that combine both fields
		 *
		 * @param $array
		 * @return $this
		 */
		public function innerJoin($array)
		{
			$this->secondaryArray = json_decode($array, true);
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
			$this->secondaryArray = json_decode($array, true);
			$this->joinType = "left";

			return $this;
		}
	}