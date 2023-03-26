<?php

require_once("lib/process/person/KBasePerson.php");
require_once("lib/data_struct/KArray.php");

class KManagerPerson extends KBasePerson {

    protected $members;

    protected function initialize()
    {
        $this->members = new KArray();

        return $this;
    }

    public function addMember($member) {

    }

    public function askJob($job, $member) {

    }

    public function ask($member, $something) {

    }

    public function sendMail($member, $contentOfMail) {

    }

    public function sendMessage($member, $contentOfMessage) {

    }

    public function sendMemo($member, $contentOfMemo) {

    }

    public function broadCastMessage($contentOfMessage) {

    }

    public function broadCastJob($jobs) {

    }

}

?>