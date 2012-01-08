TurtlePHP Config Plugin
===
TurtlePHP configuration plugin, that provides a standard for retrieving and
storing an application&#039;s configuration settings.

### Example Usage
    /**
     * Config
     */
    require_once APP . &#039;/plugins/Config.class.php&#039;;
    require_once APP . &#039;/includes/setup/config.inc.php&#039;;
    $config = \Plugin\Config::retrieve();

