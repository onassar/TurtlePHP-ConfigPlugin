TurtlePHP Config Plugin
===
TurtlePHP configuration plugin which provides a standardized approach for
storing and retrieving an application&#039;s configuration settings.

### Example Usage
    /**
     * Config
     */
    require_once APP . &#039;/plugins/Config.class.php&#039;;
    require_once APP . &#039;/includes/setup/config.inc.php&#039;;
    $config = \Plugin\Config::retrieve();

