TurtlePHP-ConfigPlugin
======================

[TurtlePHP](https://github.com/onassar/TurtlePHP) Configuration Plugin which
provides a standardized approach for getting, setting and removing config
settings.

### Sample plugin loading:
``` php
require_once APP . '/plugins/TurtlePHP-BasePlugin/Base.class.php';
require_once APP . '/plugins/TurtlePHP-ConfigPlugin/Config.class.php';
$path = APP . '/config/plugins/config.inc.php';
TurtlePHP\Plugin\Config::setConfigPath($path);
TurtlePHP\Plugin\Config::init();
```

### Sample get
``` php
TurtlePHP\Plugin\Config::get('key');
TurtlePHP\Plugin\Config::get('key.subkey');
TurtlePHP\Plugin\Config::get('key', 'subkey');
TurtlePHP\Plugin\Config::get('key', 'subkey.subsubkey');
```

### Sample set
``` php
TurtlePHP\Plugin\Config::set('key', 'value');
TurtlePHP\Plugin\Config::set('key.subkey', 'value');
TurtlePHP\Plugin\Config::set(array('key', 'subkey'), 'value');
```

### Sample merge
``` php
TurtlePHP\Plugin\Config::set('key.subkey', 'value');
TurtlePHP\Plugin\Config::merge('key.subkey', 'value2');
TurtlePHP\Plugin\Config::merge(array('key', 'subkey'), 'value2');
```

### Sample remove
``` php
TurtlePHP\Plugin\Config::remove('key');
TurtlePHP\Plugin\Config::remove('key.subkey');
TurtlePHP\Plugin\Config::remove('key', 'subkey');
TurtlePHP\Plugin\Config::remove('key', 'subkey.subsubkey');
```
