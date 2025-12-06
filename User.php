<?php

class User
{
    public $email;
    public $type;
    public $uid;
    public $sid;

    public function __construct($email, $type, $uid, $sid = null)
    {
        $this->email = $email;
        $this->type = $type;
        $this->uid = $uid;
        $this->sid = $sid;
    }
}
