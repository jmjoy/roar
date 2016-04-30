<?php

namespace roar\base\controller;

use roar\base\GetSetter;

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

trait Request {
    use GetSetter;

    private $get;
    private $post;
    private $server;
    private $cookie;
}

trait Response {
    use GetSetter;

    private $view;
}

trait View {
    use GetSetter;
}

class AccessException extends \Exception {}