<?php

require_once("lib/process/person/KBasePerson.php");
require_once("lib/data_struct/KHash.php");
require_once("lib/util/KLogger.php");

class KManagerPerson extends KBasePerson {

    protected $members;
    protected $mailer;
    protected $messagingSystem;
    protected $memoDispacher;

    protected function initialize()
    {
        $this->members = new KHash();

        return $this;
    }

    public function addMember($member) {
        $this->members->set($member->getId(), $member);

        return $this;
    }

    public function askJob($memberId, $job) {
        $member = $this->members->askJob($memberId);

        $member->askJob($job);

        return $this;
    }

    public function ask($memberId, $something) {
        $member = $this->members->get($memberId);

        $member->ask($something);

        return $this;
    }

    public function sendMail($memberId, $contentOfMail) {
        try {
            $member = $this->members->get($memberId);
        }
        catch(KException $ex) {
            $msg = "catched by KManagerPerson::sendMail(): something wrong with member::get of members: " . $memberId . " " . $ex->getMessage();

            TheWorld::instance()->logger->log(KLogger::WARN, $msg);

            // Finally catched by top level of framework.
            throw $ex;
        }

        $this->mailer->sendMail(
            $member->getEmailAddress(), 
            $contentOfMail->getTo(), 
            $contentOfMail->getSubject(), 
            $contentOfMail->getContent()
        );

        return $this;
    }

    public function sendMessage($memberId, $contentOfMessage) {

    }

    public function sendMemo($memberId, $contentOfMemo) {

    }

    public function broadCastMessage($contentOfMessage) {
        // debug
        // KHash and KSeq has not been properly impled and tested yet.
        $this->members->each(function($memberId, $member) {
            $this->sendMessage($memberId, $contentOfMessage);
        });
        // end of debug

        return $this;
    }

    public function broadCastMail($contentOfMail) {

    }

    public function broadCastMemo($contentOfMemo) {

    }

    public function broadCastJob($jobs) {

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