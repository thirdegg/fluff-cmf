<?php

class EmptyParramsException extends Exception {
    public function __construct() {
        parent::__construct("required param is empty", 101, null);
    }
}

?>