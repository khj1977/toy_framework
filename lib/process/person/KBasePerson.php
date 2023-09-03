<?php

require_once("lib/BaseClass.php");

// Sub class would be Member, Manager and so on.
// Process has person and person talks to another person or process.
class KBasePerson extends BaseClass {

    protected $memberId;

    protected $mailer;
    protected $messagingSystem;
    protected $memoDispacher;

    public function getMemberId() {
        return $this->memberId;
    }

    public function askJob($job) {

    }

    public function ask($something) {

    }

    public function sendMessage($contentOfMessage) {

    }

    public function sendMemo($contentOfMemo) {

    }

    public function setMailer($mailer) {
        $this->mailer = $mailer;

        return $this;
    }

    public function setMessagingSystem($msgSys) {
        $this->messagingSystem = $msgSys;

        return $this;
    }

    public function setMemoDispatcher($memoDispatcher) {
        $this->memoDispacher = $memoDispatcher;

        return $this;
    }

}

?>