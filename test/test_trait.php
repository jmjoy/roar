<?php

require_once '../framework/pattern/mod.php';

class A {
    use \roar\pattern\GetSetter;
}

// var_dump(class_uses('A'));
var_dump(get_declared_traits());