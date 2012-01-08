<?php

    // namespace
    namespace Plugin;

    /**
     * Config
     * 
     * Statically accessed <retrieve> and <store> methods to facilitate
     * application configuration. While not comprehensive, clean and should be
     * used as a standard for TurtlePHP applications.
     * 
     * @author   Oliver Nassar <onassar@gmail.com>
     * @abstract
     */
    abstract class Config
    {
        /**
         * _data
         * 
         * @var    array
         * @access protected
         * @static
         */
        protected static $_data;

        /**
         * retrieve
         * 
         * @access public
         * @static
         * @return array
         */
        public static function retrieve()
        {
            return self::$_data;
        }

        /**
         * store
         * 
         * @access public
         * @static
         * @param  array $data
         * @return void
         */
        public static function store(array $data)
        {
            self::$_data = $data;
        }
    }

