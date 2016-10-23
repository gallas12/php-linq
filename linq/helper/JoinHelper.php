<?php

	/**
	 * Created by PhpStorm.
	 * User: Milan Gallas
	 * Date: 22.10.2016
	 * Time: 21:16
	 */
	namespace Linq\Helper;

	/**
	 * Class JoinHelper
	 *
	 * @package Linq\Helper
	 */
	class JoinHelper implements IJoinHelper
	{
		/** @var Array */
		protected $firstSource;

		/** @var Array */
		protected $secondarySource;

		/** @var Array */
		protected $joinedArray;

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
					/*
					if($this->joinType == "left join" && $useLeftJoin){
						$joinedArray[] = $source;
					}*/
					//$useLeftJoin = true;
				}
			}
			return $this->joinedArray;
		}
		/**
		 * @param Array $firstSource
		 * @return JoinHelper
		 */
		public function setFirstSource($firstSource)
		{
			$this->firstSource = $firstSource;

			return $this;
		}

		/**
		 * @param Array $secondarySource
		 * @return JoinHelper
		 */
		public function setSecondarySource($secondarySource)
		{
			$this->secondarySource = $secondarySource;

			return $this;
		}

		/**
		 * @param $condition
		 * @param $source
		 * @param $secondarySource
		 */
		protected function tryMergeSources($condition, $source, $secondarySource)
		{
 			if (call_user_func_array($condition, array($source, $secondarySource))) {
				$this->mergeSources($source, $secondarySource);
			}
		}

		/**
		 * @param $source
		 * @param $secondarySource
		 */
		protected function mergeSources($source, $secondarySource)
		{
			if (is_array($source) and is_array($secondarySource)) {
				$this->joinedArray[] = array_merge_recursive($source, $secondarySource);
			} else {
				$this->joinedArray[] = (object)array_merge_recursive((array)$source, (array)$secondarySource);
			}
		}

	}