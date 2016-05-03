<?php

namespace app\controller\user;

use roar\mvc\controller\Action;

class Center {
    use Action;

    public function do_get() {
        echo 'center do_get';
    }

    public function do_post() {
    }
}

class Action {
    // use \roar\controller;

    public function do_get() {
    }

    public function do_post() {
    }
}