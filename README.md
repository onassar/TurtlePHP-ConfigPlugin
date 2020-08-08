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
Plugin\Config::setConfigPath($path);
Plugin\Config::init();
```

### Sample get
``` php
Plugin\Config::get('key');
Plugin\Config::get('key.subkey');
Plugin\Config::get('key', 'subkey');
Plugin\Config::get('key', 'subkey.subsubkey');
```

### Sample set
``` php
Plugin\Config::set('key', 'value');
Plugin\Config::set('key.subkey', 'value');
Plugin\Config::set(array('key', 'subkey'), 'value');
```

### Sample merge
``` php
Plugin\Config::set('key.subkey', 'value');
Plugin\Config::merge('key.subkey', 'value2');
Plugin\Config::merge(array('key', 'subkey'), 'value2');
```

### Sample remove
``` php
Plugin\Config::remove('key');
Plugin\Config::remove('key.subkey');
Plugin\Config::remove('key', 'subkey');
Plugin\Config::remove('key', 'subkey.subsubkey');
```
