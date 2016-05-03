<?php

abstract class abstract_dto_class {

    private $scenario;

    public function __construct($scenario = 'default') {
        $this->scenario = $scenario;
    }

    public abstract function table_name();

    public abstract function fields();

    public function scenarios() {
        return array(
            'default' => array_keys($this->fields),
        );
    }

    public function pub() {
        return array(
            'set' => function($field, $value) use($this) {
                $this->$field = $value;
            },
            'get' => function($field) use($this) {
                return $this->$field;
            },
        );
    }

    public function priv() {
        return array();
    }

    public function set_scenario($scenario) {
        $this->scenario = $scenario;
        return $this;
    }

}