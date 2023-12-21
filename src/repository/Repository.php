<?php

require_once __DIR__.'/../../Database.php';
//TODO make a singleton
class Repository
{
    protected  $database;

    public function __construct() {
        $this->database = new Database();
    }
}