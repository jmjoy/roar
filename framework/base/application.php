<?php

namespace roar\base\application;

use roar\base\autoload\Autoload;
use roar\mvc\controller;

trait ApplicationBase {

    private $config;

    private static $http_methods = array(
        "OPTIONS",
        "GET",
        "HEAD",
        "POST",
        "PUT",
        "DELETE",
        "TRACE",
        "CONNECT",
        "PATCH",
    );

    public function __construct($config) {
        $this->config = (object) $config;
    }

    public static function get_http_methods() {
        return static::$http_methods;
    }

    public function run() {
        $this->autoload();
        $action_class = $this->resolve_url();
        $this->dispatch($action_class);
    }

    private function resolve_url() {
        // TODO config
        $router = isset($_GET['r']) ? $_GET['r'] : 'index/Index';

        // TODO handle
        $router = explode('/', $router);
        $router = implode('\\', $router);

        return implode('\\', array(
            $this->config->id, 'controller', $router,
        ));
    }

    private function dispatch($action_class) {
        if (!class_exists($action_class)) {
            (new controller\NotFound())->do_get();
            return;
        }

        $action = new $action_class();
        $action->set_application($this);
        $action->set_request(new controller\Request());

        // dispatch via METHOD
        $request_method = $action->get_request()->server('REQUEST_METHOD');
        if (in_array($request_method, $this->http_methods)) {
            $method_name = 'do_' . $request_method;
            $action->$method_name();
        } else {
            $action->forbidden();
        }
    }

    private function autoload() {
        Autoload::add_module($this->config->id, $this->config->path);
        Autoload::register();
    }

}