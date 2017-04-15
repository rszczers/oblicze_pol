<?php

class Author implements \JsonSerializable {
    private $id;
    private $fname;
    private $sname;
    private $email;

    function __construct($id, $fname, $sname, $email) {
        $this->id = $id;
        $this->fname = $fname;
        $this->sname = $sname;
        $this->email = $email;
    }
    
    public function getID() {
        return $this->id;
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
