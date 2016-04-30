<?php

require_once './orm/abstract_dto_class.php';
require_once './orm/orm_operator_class.php';

class User extends abstract_dto_class {

    public function table_name() {
        return '';
    }

    public function fields() {
        return array();
    }

}

$user = new User();
$user->name = 'NAME';
$user->age = 11;

var_dump(orm_operator_class::insert($user));