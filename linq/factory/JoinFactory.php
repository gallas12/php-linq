<?php
	/**
	 * Created by PhpStorm.
	 * User: Milan Gallas
	 * Date: 22.10.2016
	 * Time: 21:26
	 */

	namespace Linq\Factory;


	use Linq\Helper\IJoinHelper;
	use Linq\Helper\JoinHelper;
	use Linq\Helper\LeftJoinHelper;

	/**
	 * Class JoinFactory
	 *
	 * @package Linq\Factory
	 */
	class JoinFactory
	{
		/** ENUM */
		const INNER = "inner";
		const LEFT = "left";

		/** @var array  */
		protected $joinObjects = array();

		/**
		 * JoinFactory constructor.
		 */
		public function __construct() {
			$this->joinObjects = array(
				"inner" => new JoinHelper(),
				"left" =>  new LeftJoinHelper()
			);
		}

		/**
		 * @param $type
		 * @return IJoinHelper
		 * @throws \Exception
		 */
		public function getJoinObject($type)
		{
			if(!in_array($type, array_keys($this->joinObjects))){
				throw new \Exception("Invalid Join Type Parametr");
			}
			return $this->joinObjects[$type];
		}
	}