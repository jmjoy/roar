<?php

namespace roar\base\controller;

use roar\base\Setter;
use roar\base\GetSetter;
use roar\util;

trait Action {
    use GetSetter;

    private $application;
    private $request;
    private $response;

    public function do_get() {
        throw new AccessException('Access Denied.');
    }

    public function do_post() {
        throw new AccessException('Access Denied.');
    }

    public function do_put() {
        throw new AccessException('Access Denied.');
    }

    public function do_delete() {
        throw new AccessException('Access Denied.');
    }

    public function do_patch() {
        throw new AccessException('Access Denied.');
    }

    public function do_head() {
        throw new AccessException('Access Denied.');
    }
}

class WebRequest {
    use Setter;

    public function get($key = null, $default = null, $callback = null) {
        return util\Arr::get($_GET, $default, $callback);
    }

    public function post($key = null, $default = null, $callback = null) {
        return util\Arr::get($_POST, $default, $callback);
    }

    public function server($key = null, $default = null, $callback = null) {
        return util\Arr::get($_SERVER, $default, $callback);
    }

    public function cookie($key = null, $default = null, $callback = null) {
        return util\Arr::get($_COOKIE, $default, $callback);
    }

    public function body() {
        return file_get_contents('php://input');
    }
}

class Response {
    use GetSetter;

    private $view;
}

class View {
    use GetSetter;
}

class AccessException extends \Exception {}