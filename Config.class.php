<?php

    // namespace
    namespace Plugin;

    /**
     * Config
     * 
     * Config plugin for TurtlePHP.
     *
     * Statically accessed <retrieve> and <add> methods to facilitate
     * application configuration. While not comprehensive, clean, and should be
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
         * _get
         * 
         * @access  protected
         * @static
         * @param   array $keys
         * @return  mixed
         */
        protected static function _get(array $keys)
        {
            $indexedKeys = static::_getIndexedKeys($keys);
            $value = static::$_data;
            foreach ($indexedKeys as $key) {
                $value = $value[$key] ?? null;
                if ($value === null) {
                    return null;
                }
            }
            return $value;
        }

        /**
         * _getIndexedKeys
         * 
         * Returns an array of keys that is numerically-indexed to ensure a
         * consistent approach to working with the keys passed in.
         * 
         * @access  protected
         * @static
         * @param   array $keys
         * @return  array
         */
        protected static function _getIndexedKeys(array $keys): array
        {
            if (count($keys) === 0) {
                return $keys;
            }
            $keys = implode('.', $keys);
            $keys = explode('.', $keys);
            return $keys;
        }

        /**
         * _removeValueByKeys
         * 
         * @access  protected
         * @static
         * @param   array $keys
         * @return  array
         */
        protected static function _removeValueByKeys(array $keys): void
        {
            $indexedKeys = static::_getIndexedKeys($keys);
            $value = static::$_data;
            foreach ($indexedKeys as $index => $key) {
                $parent = $value;
                $value = $value[$key];
            }
            unset($parent[$key]);
            array_pop($indexedKeys);
            $key = implode('.', $indexedKeys);
            static::add($key, $parent);
            // static::set($key, $parent);
        }

        /**
         * set
         * 
         * @todo
         * @access  public
         * @static
         * @param   mixed $keys
         * @param   mixed $incomingValue
         * @return  void
         */
        // public static function set($keys, $incomingValue): void
        public static function add($keys, $incomingValue): void
        {
            $keys = (array) $keys;
            $indexedKeys = static::_getIndexedKeys($keys);
            $value = &static::$_data;
            foreach ($indexedKeys as $key) {
                if (isset($value[$key]) === false) {
                    $value[$key] = array();
                    $value = &$value[$key];
                    continue;
                }
                $value = &$value[$key];
            }
            $value = $incomingValue;
        }

        /**
         * merge
         * 
         * @access  public
         * @static
         * @param   mixed $key
         * @param   mixed $incomingValue
         * @return  bool
         */
        public static function merge($keys, $incomingValue): bool
        {
            $keys = (array) $keys;
            $existingValue = static::_get($keys);
            if ($existingValue === null) {
                static::add($keys, $incomingValue);
                // static::set($keys, $incomingValue);
                return false;
            }
            $existingValue = (array) $existingValue;
            $incomingValue = (array) $incomingValue;
            $mergedValue = array_merge($existingValue, $incomingValue);
            static::add($keys, $mergedValue);
            // static::set($keys, $mergedValue);
            return true;
        }

        /**
         * remove
         * 
         * @todo
         * @access  public
         * @static
         * @param   array $keys,...
         * @return  bool
         */
        public static function remove(... $keys): bool
        {
            $value = static::_get($keys);
            if ($value === null) {
                return false;
            }
            static::_removeValueByKeys($keys);
            return true;
        }

        /**
         * get
         * 
         * @throws  \Exception
         * @access  public
         * @static
         * @param   array $keys,...
         * @return  mixed
         */
        // public static function get(... $keys)
        public static function retrieve(... $keys)
        {
            $value = static::_get($keys);
            if ($value === null) {
                $msg = 'Invalid Plugin\Config::get $key value: ' . ($key);
                throw new \Exception($msg);
            }
            return $value;
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
