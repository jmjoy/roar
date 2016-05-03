<?php

namespace roar\util\arr;

use roar\pattern;

class Arr {
    use pattern\Staticize;

    public static function get($arr, $key = null, $default = null, $callback = null) {
        if ($key === null) {
            return $arr;
        }

        $value = null;
        if (is_array($key)) {
            $value = $arr;
            foreach ($key as $k) {
                if (isset($value[$k])) {
                    $value = $value[$k];
                } else {
                    $value = $default;
                    break;
                }
            }
        } else {
            if (isset($arr[$key])) {
                $value = $arr[$key];
            } else {
                $value = $default;
            }
        }

        return ($callback === null) ? $value : $callback($value);
    }
}