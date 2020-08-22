<?php

    // Namespace overhead
    namespace TurtlePHP\Plugin;

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
            static::set($key, $parent);
        }

        /**
         * _validateKeyValues
         * 
         * @throws  \Exception
         * @access  protected
         * @static
         * @param   array $keys,...
         * @return  void
         */
        protected static function _validateKeyValues(... $keys): void
        {
            foreach ($keys as $key) {
                if (is_array($key) === true) {
                    $msg = 'Key must be a string';
                    throw new \Exception($msg);
                }
            }
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
        public static function get(... $keys)
        {
            static::_validateKeyValues(... $keys);
            $value = static::_get($keys);
            if ($value === null) {
                $indexedKeys = static::_getIndexedKeys($keys);
                $key = implode('.', $indexedKeys);
                $msg = 'Invalid TurtlePHP\Plugin\Config::get $key value:';
                $msg = ($msg) . ' ' . ($key);
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
                static::set($keys, $incomingValue);
                return false;
            }
            $existingValue = (array) $existingValue;
            $incomingValue = (array) $incomingValue;
            $mergedValue = array_merge($existingValue, $incomingValue);
            static::set($keys, $mergedValue);
            return true;
        }

        /**
         * remove
         * 
         * @access  public
         * @static
         * @param   array $keys,...
         * @return  bool
         */
        public static function remove(... $keys): bool
        {
            static::_validateKeyValues(... $keys);
            $value = static::_get($keys);
            if ($value === null) {
                return false;
            }
            static::_removeValueByKeys($keys);
            return true;
        }

        /**
         * set
         * 
         * @access  public
         * @static
         * @param   mixed $keys
         * @param   mixed $incomingValue
         * @return  void
         */
        public static function set($keys, $incomingValue): void
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
    }

    // Config path loading
    $info = pathinfo(__DIR__);
    $parent = ($info['dirname']) . '/' . ($info['basename']);
    $configPath = ($parent) . '/config.inc.php';
    \TurtlePHP\Plugin\Config::setConfigPath($configPath);
