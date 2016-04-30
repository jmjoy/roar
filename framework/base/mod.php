<?php

namespace roar\base;

trait Single {
    use Util;

    private $instance;

    public function getInstance() {
        if ($this->instance === null) {
            $this->instance = new static();
        }
        return $this->instance();
    }

}

trait Util {
    private function __construct() {}

    private function __clone() {}
}

trait Getter {
    public function __call($name, $args) {
        if (strpos($name, 'get_') === 0) {
            return $this->on_get_call($name);
        }
    }

    private function on_get_call($name) {
        $field = substr($name, 4);
        if (!property_exists($this, $field)) {
            throw new \BadMethodCallException("Field `{$field}` not exists.");
        }
        return $this->$field;
    }
}

trait Setter {
    public function __call($name, $args) {
        if (strpos($name, 'set_') === 0) {
            return $this->on_set_call($name, $args);
        }
    }

    private function on_set_call($name, $args) {
        $field = substr($name, 4);
        if (!property_exists($this, $field)) {
            throw new \BadMethodCallException("Field `{$field}` not exists.");
        }
        $this->$field = $args[0];
        return $this;
    }
}

trait GetSetter {
    use Getter, Setter;

    public function __call($name, $args) {
        if (strpos($name, 'get_') === 0) {
            return $this->on_get_call($name);
        }
        if (strpos($name, 'set_') === 0) {
            return $this->on_set_call($name, $args);
        }
    }
}