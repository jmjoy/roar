<?php

final class orm_operator_class {

    private function __construct() {}

    public function insert(abstract_dto_class $dto) {
        return json_encode($dto);
    }

}