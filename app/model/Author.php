<?php

class Author implements \JsonSerializable {
    private $fname;
    private $sname;
    private $email;

    function __construct($fname, $sname, $email) {
        $this->fname = $fname;
        $this->sname = $sname;
        $this->email = $email;
    }
    
    public function getFullName() {
        return $this->fname . ' ' . $this->sname;
    }
    
    public function getEmail() {
        return $this->email;
    }

    public function jsonSerialize() {
        $vars = get_object_vars($this);
        return $vars;
    }

}
