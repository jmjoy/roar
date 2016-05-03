<?php

namespace roar\base\application;

use roar\base\autoload\Autoload;
use roar\mvc\controller;

trait ApplicationBase {

    private $config;

    public function __construct($config) {
        $this->config = (object) $config;
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
        switch ($action->get_request()->server('REQUEST_METHOD')) {
        case 'GET':
            $action->do_get();
            break;
        case 'POST':
            $action->do_post();
            break;
        case 'PUT':
            $action->do_put();
            break;
        case 'DELETE':
            $action->do_delete();
            break;
        case 'PATCH':
            $action->do_patch();
            break;
        case 'HEAD':
            $action->do_head();
            break;
        default:
            $action->forbidden();
        }
    }

    private function autoload() {
        Autoload::add_module($this->config->id, $this->config->path);
        Autoload::register();
    }

}