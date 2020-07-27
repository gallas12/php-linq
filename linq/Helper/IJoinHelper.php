<?php
	/**
	 * Created by PhpStorm.
	 * User: Milan Gallas
	 * Date: 22.10.2016
	 * Time: 21:44
	 */

	namespace Linq\Helper;

	interface IJoinHelper{

		/**
		 * @param $condition
		 * @return Array
		 */
		public function join($condition);

		/**
		 * @param Array $firstSource
		 * @return JoinHelper
		 */
		public function setFirstSource($firstSource);


		/**
		 * @param Array $secondarySource
		 * @return JoinHelper
		 */
		public function setSecondarySource($secondarySource);
	}
