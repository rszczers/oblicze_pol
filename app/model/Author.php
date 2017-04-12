<?php

class Author {
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
}
