<?php

namespace app\controller\index;

use roar\mvc\controller\Action;

class Index {
    use Action;

    public function do_get() {
        var_dump($this->request->get());
    }
}