TurtlePHP Config Plugin
===
TurtlePHP configuration plugin which provides a standardized approach for
storing and retrieving an application&#039;s configuration settings.

### Example Usage
    /**
     * Config
     */
    require_once APP . '/plugins/Config.class.php';
    require_once APP . '/includes/setup/config.inc.php';
    $config = \Plugin\Config::retrieve();

