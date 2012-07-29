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
         * __cascade
         * 
         * Writes data, recursively, to child-array's in order to allow variable
         * passing in the following syntax:
         * 
         * $this->_pass('name', 'value');
         * $this->_pass('page.title', 'title');
         * 
         * Based on the above syntax, the following variables are available to
         * the view:
         * 
         * $name = 'value';
         * $page = array(
         *     'title' => 'title'
         * );
         * 
         * @access private
         * @static
         * @param  Array &$variables
         * @param  Array $key array of keys which are used to make associative
         *         references in <$variables>
         * @param  mixed $mixed variable which is written to <$variables>
         *         reference, based on $keys as associative indexes
         * @return void
         */
        private static function __cascade(array &$variables, array $keys, $mixed)
        {
            $key = array_shift($keys);
            if (!isset($variables[$key]) || !is_array($variables[$key])) {
                $variables[$key] = array();
            }
            if (!empty($keys)) {
                self::__cascade($variables[$key], $keys, $mixed);
            } else {
                $variables[$key] = $mixed;
            }
        }

        /**
         * add
         * 
         * @access public
         * @static
         * @param  string $key
         * @param  mixed $mixed
         * @return array
         */
        public static function add($key, array $mixed)
        {
            // if <$mixed> should be stored in a child-array
            if (strstr($key, '.')) {
                $keys = explode('.', $key);
                self::__cascade(self::$_data, $keys, $mixed);
            
            } else {
                self::$_data[$key] = $mixed;
            }
        }

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
