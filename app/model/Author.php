<?php
class Author extends User {
    private $authorid;

    function __construct($aid, $fname, $sname, $uid, $email) {
        parent::__construct($uid, $fname, $sname, $email);
        $this->authorid = $aid;
    }
    
    public function getAID() {
        return $this->authorid;
    }
    
    public function getUID() {
        return $this->getID();
    }
    
    public function getEmail() {
        return $this->email;
    }
}
