<?php

namespace roar\mvc\controller;

use roar\base;
use roar\pattern\Setter;
use roar\pattern\GetSetter;
use roar\util;
use roar\exception\http;
use roar\util\arr\Arr;

trait Action {
    use GetSetter;

    private $application;
    private $request;
    private $response;
    private $view;

    public function __call($name, $args) {
        if (strpos($name, 'do_') === 0) {
            throw new http\ForbiddenException('Access Denied.');
        }
    }

    public function forbidden() {
        throw new http\ForbiddenException('Access Denied.');
    }
}

class Request {
    use Setter, SaveParentAction;

    public function get($key = null, $default = null, $callback = null) {
        return Arr::get($_GET, $key, $default, $callback);
    }

    public function post($key = null, $default = null, $callback = null) {
        return Arr::get($_POST, $key, $default, $callback);
    }

    public function server($key = null, $default = null, $callback = null) {
        return Arr::get($_SERVER, $key, $default, $callback);
    }

    public function cookie($key = null, $default = null, $callback = null) {
        return Arr::get($_COOKIE, $key, $default, $callback);
    }

    public function body() {
        return file_get_contents('php://input');
    }
}

class Response {
    use GetSetter, SaveParentAction;

    private $view;
}

class View {
    use GetSetter, SaveParentAction;

    private $response;

    public function __construct($action, $response) {
        $this->action = $action;
        $this->response = $response;
    }
}

trait SaveParentAction {
    private $action;

    public function __construct($action) {
        $this->action = $action;
    }
}

class NotFound {
    use Action;

    public function do_get() {
        throw new http\NotFoundException();
    }
}