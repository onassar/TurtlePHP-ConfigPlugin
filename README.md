TurtlePHP Config Plugin
===
TurtlePHP configuration plugin which provides a standardized approach for
storing and retrieving an application&#039;s configuration settings.

### Example Storage
    <?php
    
        // setting initializing
        $cookies = array();
        $runtime = array();
    
        /**
         * Cookies
         */
        $cookies = array(
            'onassar' => array(
                'host' => '.local.turtlephp.com'
            ),
            'production' => array(
                'host' => '.turtlephp.com'
            )
        );
        
        /**
         * PHP Runtime
         */
        $runtime = array(
            'onassar' => array(
                'max_execution_time' => 3,
                'memory_limit' => '16M'
            ),
            'production' => array(
                'max_execution_time' => 10,
                'memory_limit' => '128M'
            )
        );
    
        // config storage
        \Plugin\Config::store(array(
            'cookies' => $cookies,
            'runtime' => $runtime
        ));

### Example Retrieval
    /**
     * Config
     */
    require_once APP . '/plugins/Config.class.php';
    require_once APP . '/includes/setup/config.inc.php';
    $config = \Plugin\Config::retrieve();

