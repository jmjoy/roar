<?php

namespace roar\exception\http;

class HttpException extends \Exception {}

class ForbiddenException extends HttpException {

    public function __construct($previous = null) {
        parent::__construct('Forbidden', 403, $previous);
    }
}

class NotFoundException extends HttpException {

    public function __construct($previous = null) {
        parent::__construct('Not found', 404, $previous);
    }
}