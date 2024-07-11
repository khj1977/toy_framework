<?php

// debug
// implement this class.
// end of debug

require_once("lib/BaseClass.php");
require_once("lib/TheWorld.php");

class Auth extends BaseClass {

    protected $isAuthed;

    protected $userName;
    protected $hashedPassword;

    protected function initialize() {
        parent::initialize();

        $this->isAuthed = false;

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

    // debug
    // Don't take log on MyPDO.
    // end of debug
    public function askAuth() {
        $sql = "SELECT count(id) as cnt FROM auth WHERE user_name = ? and hashed_password = ?";

        $pdo = TheWorld::instance()->slave;
        $statement = $pdo->prepare($sql);

        $statement->execute(array($this->userName, $this->hashedPassword));
        $rows = $statement->fetch();

        $cnt = $rows["cnt"];
        if ($cnt != "1") {
            return false;
        }

        return true;
    }

    public function doExpire() {
        $this->isAuthed = false;

        return $this;
    }

    protected function getHash($rawPassword) {
        $hash = hash("sha256", $rawPassword);

        return $hash;
    }

}


?>