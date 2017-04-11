<?php
class userView {
    private $code;
    private $name;
    
    function __construct($code, $name) {
        $this->code = $code;
        $this->name = $name;
    }
}
