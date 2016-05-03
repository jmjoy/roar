<?php

namespace roar\mvc\controller;

use roar\pattren\Setter;
use roar\pattren\GetSetter;
use roar\util;
use roar\exception\http;

trait Action {
    use GetSetter;

    private $application;
    private $request;
    private $response;

    public function do_get() {
        throw new http\ForbiddenException('Access Denied.');
    }

    public function do_post() {
        throw new http\ForbiddenException('Access Denied.');
    }

    public function do_put() {
        throw new http\ForbiddenException('Access Denied.');
    }

    public function do_delete() {
        throw new http\ForbiddenException('Access Denied.');
    }

    public function do_patch() {
        throw new http\ForbiddenException('Access Denied.');
    }

    public function do_head() {
        throw new http\ForbiddenException('Access Denied.');
    }

    public function forbidden() {
        throw new http\ForbiddenException('Access Denied.');
    }
}

class Request {
    use Setter;

    public function get($key = null, $default = null, $callback = null) {
        return util\Arr::get($_GET, $key, $default, $callback);
    }

    public function post($key = null, $default = null, $callback = null) {
        return util\Arr::get($_POST, $key, $default, $callback);
    }

    public function server($key = null, $default = null, $callback = null) {
        return util\Arr::get($_SERVER, $key, $default, $callback);
    }

    public function cookie($key = null, $default = null, $callback = null) {
        return util\Arr::get($_COOKIE, $key, $default, $callback);
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

class NotFound {
    use Action;

    public function do_get() {
        throw new http\NotFoundException();
    }
}