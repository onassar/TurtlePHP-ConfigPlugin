<?php

    // namespace
    namespace Plugin;

    /**
     * Config
     * 
     * Config plugin for TurtlePHP.
     *
     * Statically accessed <retrieve> and <add> methods to facilitate
     * application configuration. While not comprehensive, clean and should be
     * used as a standard for TurtlePHP applications.
     *
     * @author  Oliver Nassar <onassar@gmail.com>
     * @abstract
     * @extends Base
     */
    abstract class Config extends Base
    {
        /**
         * _configPath
         *
         * @access  protected
         * @var     string (default: 'config.default.inc.php')
         * @static
         */
        protected static $_configPath = 'config.default.inc.php';

        /**
         * _data
         *
         * @access  protected
         * @var     array (default: array())
         * @static
         */
        protected static $_data = array();

        /**
         * _initiated
         *
         * @access  protected
         * @var     bool (default: false)
         * @static
         */
        protected static $_initiated = false;

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
        private static function _cascade(array &$variables, array $keys, $mixed): void
        {
            $key = array_shift($keys);
            if (
                isset($variables[$key]) === false
                || is_array($variables[$key]) === false
            ) {
                $variables[$key] = array();
            }
            if (empty($keys) === false) {
                static::_cascade($variables[$key], $keys, $mixed);
            } else {
                $variables[$key] = $mixed;
            }
        }

        /**
         * _checkDependencies
         * 
         * @access  protected
         * @static
         * @return  void
         */
        protected static function _checkDependencies(): void
        {
        }

        /**
         * add
         *
         * @access  public
         * @static
         * @param   string $key
         * @param   mixed $data
         * @return  bool
         */
        public static function add($key, array $data): bool
        {
            // if $data should be stored in a child-array
            if (strstr($key, '.') !== false) {
                $keys = explode('.', $key);
                static::_cascade(static::$_data, $keys, $data);
                return true;
            }
            static::$_data[$key] = $data;
            return true;
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
            unset(static::$_data[$key]);
        }

        /**
         * retrieve
         *
         * @throws  \Exception
         * @access  public
         * @static
         * @return  mixed
         */
        public static function retrieve()
        {
            $args = func_get_args();
            if (count($args) === 0) {
                return static::$_data;
            }
            $current = static::$_data;
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

        /**
         * init
         * 
         * @access  public
         * @static
         * @return  bool
         */
        public static function init(): bool
        {
            if (static::$_initiated === true) {
                return false;
            }
            parent::init();
            return true;
        }
    }

    // Config path loading
    $info = pathinfo(__DIR__);
    $parent = ($info['dirname']) . '/' . ($info['basename']);
    $configPath = ($parent) . '/config.inc.php';
    \Plugin\Config::setConfigPath($configPath);
