<?php
	/**
	 * Created by PhpStorm.
	 * User: Milan Gallas
	 * Date: 23.10.2016
	 * Time: 0:03
	 */

	namespace Linq;


	class XmlLinq extends  Linq
	{

		/**
		 * load xml string and transform to array
		 * @param type $file
		 * @return $this
		 */
		public function from($file)
		{
			$this->array = $this->parse($file);
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
			$this->secondaryArray = $this->parse($array);
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
			$this->secondaryArray = $this->parse($array);
			$this->joinType = "left";
			return $this;
		}

		/**
		 * @param $source
		 * @return mixed
		 */
		protected function parse($source)
		{
			if($source instanceof \SimpleXMLElement){
				return $this->simpleXmlElement2Array($source);
			}
			return $this->xml2array($source);
		}

		/**
		 * @param $xmlstring
		 * @return mixed
		 */
		protected function xml2array($xmlstring)
		{
			$xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
			$json = json_encode($xml);
			$array = json_decode($json,TRUE);
			return $array[array_keys($array)[0]];
		}

		/**
		 * parse SimleXmlElement object to array
		 * @param $xmlElement
		 * @return mixed
		 */
		protected function simpleXmlElement2Array($xmlElement)
		{
			$array = (array)json_decode(json_encode($xmlElement));
			$key = array_keys($array)[0];
			return $array[$key];
		}

	}