<?php
	/**
	 * Created by PhpStorm.
	 * User: Milan Gallas
	 * Date: 22.10.2016
	 * Time: 21:36
	 */

	namespace Linq\Helper;

	/**
	 * Class LeftJoinHelper
	 *
	 * @package Linq\Helper
	 */
	class LeftJoinHelper extends JoinHelper
	{
		/** @var boolean */
		protected $tryLeftJoin = true;

		/**
		 * @param $condition
		 * @return Array
		 */
		public function join($condition)
		{
			if(is_callable($condition)){
				foreach($this->firstSource as $source){
					foreach($this->secondarySource as $secondarySource){
						$this->tryMergeSources($condition, $source, $secondarySource);
					}

					if($this->tryLeftJoin){
						$this->joinedArray[] = $source;
					}
					$this->tryLeftJoin = true;
				}
			}
			return $this->joinedArray;
		}

		/**
		 * @param $source
		 * @param $secondarySource
		 */
		protected function mergeSources($source, $secondarySource)
		{
			parent::mergeSources($source, $secondarySource);
			$this->tryLeftJoin = false;
		}


	}