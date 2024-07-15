<?php

require_once("lib/BaseClass.php");
require_once("lib/TheWorld.php");

class KAuth extends BaseClass {

    protected $isAuthed;

    protected $userName;
    protected $hashedPassword;

    protected function initialize() {
        parent::initialize();

        $session = TheWorld::instance()->session;
        $authed = $session->get("Auth::is_authed");

        if (!empty($authed)) {
            if ($authed === true) {
                $this->isAuthed = true;
            }
            else {
                $this->isAuthed = false;
            }
        }

        return $this;
    }

    public function doAuth($id, $rawPassword) {
        $this->setUserID($id, $rawPassword);
        $this->askAuth();

        return $this;
    }

    public function setUserID($id, $rawPassword) {
        $this->userName = $id;
        $this->hashedPassword = $this->getHash($rawPassword);

        return $this;
    }

    public function isAuthed() {
        return $this->isAuthed;
    }

    public function askAuth() {
        $sql = "SELECT count(id) as cnt FROM auth WHERE user_name = ? and hashed_password = ?";

        $pdo = TheWorld::instance()->slave;
        $statement = $pdo->prepare($sql, false);

        $statement->execute(array($this->userName, $this->hashedPassword));
        $row = $statement->fetch();

        $cnt = $row["cnt"];
        if ($cnt != "1") {
            return false;
        }

        $this->isAuthed = true;
        $this->syncWithSession();

        return true;
    }

    public function doExpire() {
        $this->isAuthed = false;

        // debug
        // add handling of session.
        // end of debug

        return $this;
    }

    protected function syncWithSession() {
        $session = TheWorld::instance()->session;

        $session->set("Auth::is_authed", $this->isAuthed);

        return $this;
    }

    protected function getHash($rawPassword) {
        $hash = hash("sha256", $rawPassword);

        return $hash;
    }

}


?>