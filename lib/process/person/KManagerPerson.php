<?php

require_once("lib/process/person/KBasePerson.php");
require_once("lib/data_struct/KHash.php");

class KManagerPerson extends KBasePerson {

    protected $members;

    protected function initialize()
    {
        $this->members = new KHash();

        return $this;
    }

    public function addMember($member) {

    }

    public function askJob($memberId, $job) {

    }

    public function ask($memberId, $something) {

    }

    public function sendMail($memberId, $contentOfMail) {

    }

    public function sendMessage($memberId, $contentOfMessage) {

    }

    public function sendMemo($memberId, $contentOfMemo) {

    }

    public function broadCastMessage($contentOfMessage) {

    }

    public function broadCastJob($jobs) {

    }

}

?>