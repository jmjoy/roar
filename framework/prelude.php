<?php

namespace roar\prelude;

use roar\base\Util;
use roar\base\controller\Request;

define('ROAR_PATH', realpath(__DIR__));

require_once  __DIR__ . '/base/mod.php';

class Application {

    private $config;

    public function __construct($config) {
        $this->config = (object) $config;
    }

    public function run() {
        Autoload::add_module($this->config->id, $this->config->path);
        Autoload::register();

        $this->resolve_url();
    }

    public function resolve_url() {
        // TODO config
        $router = isset($_GET['r']) ? $_GET['r'] : 'index/Index';

        // TODO handle
        $router = explode('/', $router);
        $router = implode('\\', $router);

        $controller_class = implode('\\', array(
            $this->config->id, 'controller', $router,
        ));

        $controller = new $controller_class();
        $controller->set_application($this);
        $controller->set_request(new Request());

        // dispatch via METHOD
        switch ($controller->get_request()->server('REQUEST_METHOD')) {
        case 'GET':
            $controller->do_get();
            break;
        case 'POST':
            $controller->do_post();
            break;
        case 'PUT':
            $controller->do_put();
            break;
        case 'DELETE':
            $controller->do_delete();
            break;
        case 'PATCH':
            $controller->do_patch();
            break;
        case 'HEAD':
            $controller->do_head();
            break;
        default:
            $controller->forbidden();
        }
    }

    public function resolve_config() {
    }
}

class Autoload {
    use Util;

    private static $module_map = array(
        'roar' => __DIR__,
    );

    public static function add_module($app_name, $dir) {
        static::$module_map[$app_name] = realpath($dir);
    }

    public static function register() {
        spl_autoload_register('\roar\prelude\Autoload::autoload', true);
    }

    private static function autoload($class) {
        $class_slice = explode('\\', $class);

        if (count($class_slice) == 0) {
            throw new AutoloadException('empty class');
        }

        if (!isset(static::$module_map[$class_slice[0]])) {
            throw new AutoloadException("module not exists: `{$class_slice[0]}`");
        }

        $class_slice[0] = static::$module_map[$class_slice[0]];
        array_pop($class_slice);
        $path = implode(DIRECTORY_SEPARATOR, $class_slice);

        if (is_dir($path)) {
            $mod_path = $path . DIRECTORY_SEPARATOR . 'mod.php';
            if (is_file($mod_path)) {
                require $mod_path;
                return;
            }
        } else {
            $php_path = $path . '.php';
            if (is_file($php_path)) {
                require $php_path;
                return;
            }
        }
    }

}

class AutoloadException extends \Exception {}