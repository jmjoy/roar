<?php

namespace roar\exception;

abstract class CustomException extends \Exception {

    public $data;

    public function __construct($data = null, $message = '', $code = 0, $previous = null) {
        $this->data = $data;
        parent::__construct($message, $code, $previous);
    }
}

class AutoloadException extends \Exception {}