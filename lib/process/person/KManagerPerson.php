<?php

require_once("lib/process/person/KBasePerson.php");
require_once("lib/data_struct/KHash.php");
require_once("lib/util/KLogger.php");
require_once("lib/KException.php");

class KManagerPerson extends KBasePerson {

    protected $members;
    protected $messagingSystem;
    protected $memoDispacher;

    protected function initialize()
    {
        $this->members = new KHash();

        return $this;
    }

    public function addMember($member) {
        // debug
        // Check whether there is member with that ID.
        if ($this->members->check($member->getId())) {
            throw new KException("KManagerPerson::addMember(): this member is already in members.");
        }

        $this->members->set($member->getId(), $member);
        // end of debug

        return $this;
    }

    public function askJobToMember($memberId, $job) {
        // debug
        // Check whether there is member with that ID.
        $member = $this->members->askJob($memberId);
        // end of debug

        $member->askJob($job);

        return $this;
    }

    public function askToMember($memberId, $something) {
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

    public function sendMessageToMember($memberId, $contentOfMessage) {

    }

    public function sendMemoToMember($memberId, $contentOfMemo) {

    }

    public function broadCastMessage($contentOfMessage) {
        $this->members->each(function($memberId) use ($contentOfMessage) {
            // if member is required, $this->members->get($memberId) will be used.
            $this->sendMessage($memberId, $contentOfMessage);
        });

        return $this;
    }

    public function broadCastMail($contentOfMail) {

    }

    public function broadCastMemo($contentOfMemo) {

    }

    public function broadCastJob($jobs) {

    }

    

}

?>