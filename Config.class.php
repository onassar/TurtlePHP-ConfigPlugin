<?php

    // namespace
    namespace Plugin;

    /**
     * Config
     *
     * Statically accessed <retrieve> and <add> methods to facilitate
     * application configuration. While not comprehensive, clean and should be
     * used as a standard for TurtlePHP applications.
     *
     * @author  Oliver Nassar <onassar@gmail.com>
     * @abstract
     */
    abstract class Config
    {
        /**
         * _data
         *
         * @access  protected
         * @var     array (default: array())
         * @static
         */
        protected static $_data = array();

        /**
         * _cascade
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
         * @access  private
         * @static
         * @param   array &$variables
         * @param   array $keys array of keys which are used to make associative
         *          references in <$variables>
         * @param   mixed $mixed variable which is written to <$variables>
         *          reference, based on $keys as associative indexes
         * @return  void
         */
        private static function _cascade(array &$variables, array $keys, $mixed)
        {
            $key = array_shift($keys);
            if (
                isset($variables[$key]) === false
                || is_array($variables[$key]) === false
            ) {
                $variables[$key] = array();
            }
            if (empty($keys) === false) {
                self::_cascade($variables[$key], $keys, $mixed);
            } else {
                $variables[$key] = $mixed;
            }
        }

        /**
         * add
         *
         * @access  public
         * @static
         * @param   string $key
         * @param   mixed $mixed
         * @return  void
         */
        public static function add($key, array $mixed)
        {
            // if <$mixed> should be stored in a child-array
            if (strstr($key, '.') !== false) {
                $keys = explode('.', $key);
                self::_cascade(self::$_data, $keys, $mixed);

            } else {
                self::$_data[$key] = $mixed;
            }
        }

        /**
         * remove
         *
         * @access  public
         * @static
         * @param   string $key
         * @return  void
         */
        public static function remove($key)
        {
            unset(self::$_data[$key]);
        }

        /**
         * retrieve
         *
         * @throws  Exception
         * @access  public
         * @static
         * @return  mixed
         */
        public static function retrieve()
        {
            $args = func_get_args();
            if (count($args) === 0) {
                return self::$_data;
            }
            $current = self::$_data;
            foreach ($args as $key) {
                if (isset($current[$key]) === true) {
                    $current = $current[$key];
                    continue;
                }
                $msg = 'Invalid config key';
                throw new \Exception($msg);
            }
            return $current;
        }
    }

    // Load global functions
    require_once 'global.inc.php';
