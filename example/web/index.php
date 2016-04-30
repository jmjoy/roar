<?php

require_once __DIR__ . '/../../framework/prelude.php';

$config = require '../config/config.php';
(new \roar\prelude\Application($config))->run();

(new \app\controller\user\Center())->do_get();
