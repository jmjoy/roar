<?php

namespace roar\base\autoload;

use roar\pattern;
use roar\exception\AutoloadException;

class Autoload {
    use pattern\Staticize;

    private static $module_map = array(
        'roar' => ROAR_PATH,
    );

    public static function add_module($app_name, $dir) {
        static::$module_map[$app_name] = realpath($dir);
    }

    public static function register() {
        spl_autoload_register([static::class, 'autoload'], true);
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
