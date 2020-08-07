TurtlePHP-ConfigPlugin
======================

[TurtlePHP](https://github.com/onassar/TurtlePHP) Configuration Plugin which
provides a standardized approach for storing and retrieving an
application&#039;s configuration settings.  
This plugin is most useful when used with the TurtlePHP
[Roles Plugin](https://github.com/onassar/TurtlePHP-RolesPlugin).


### Sample plugin loading:
``` php
require_once APP . '/plugins/TurtlePHP-BasePlugin/Base.class.php';
require_once APP . '/plugins/TurtlePHP-ConfigPlugin/Config.class.php';
$path = APP . '/config/plugins/config.inc.php';
Plugin\Config::setConfigPath($path);
Plugin\Config::init();
```

### Example Storage
``` php
<?php

    // setting initializing
    $cookies = array();
    $runtime = array();

    /**
     * Cookies
     */
    $cookies = array(
        'local' => array(
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
        'local' => array(
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

```

### Example Retrieval
``` php
<?php

    /**
     * Config
     */
    require_once APP . '/plugins/TurtlePHP-ConfigPlugin/Config.class.php';
    require_once APP . '/includes/setup/config.inc.php';
    $config = \Plugin\Config::retrieve();

```
