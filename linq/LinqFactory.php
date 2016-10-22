<?php
    /**
     * Created by PhpStorm.
     * User: Milan Gallas
     * Date: 6.4.2016
     * Time: 8:49
     */

    namespace Linq;

    use Linq\Factory\JoinFactory;

    class LinqFactory
    {
        /** @var JoinFactory */
        protected static $linqs = array();

        /**
         * Vytvoří klasický linq. Ten umí pracovat s polem a koĺekcí objektů
         * @return Linq
         */
        public static function createLinq()
        {

            if(!isset(self::$linqs["linq"])){
                self::$linqs["linq"] = new Linq( new JoinFactory() );
            }
            return self::$linqs["linq"];
        }

        /**
         * Potomek třídy Linq, který umí pracovat s json soubory
         * @return JsonLinq
         */
        public static function createJsonLinq()
        {
            self::load();

            return new JsonLinq();
        }

        /**
         * Potomek třídy Linq, který umí pracovat s xml soubory
         * @return XmlLinq
         */
        public static function createXmlLinq()
        {
            self::load();

            return new XmlLinq();
        }

        /**
         * Potomek třídy linq, který umí pracovat s kolekcí doctrine.
         * @return DoctrineObjectLinq
         */
		public static function createDoctrineObjectLinq()
		{
			self::load();

			return new DoctrineObjectLinq();
		}

        /**
         * Potomek třídy linq, který umí pracovat se soubory typu xls a xlsx
         * @return ExcelLinq
         */
        public static function createExcelLinq()
        {
            self::load();

            return new ExcelLinq();
        }
    }