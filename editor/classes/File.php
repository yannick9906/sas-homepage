<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 19.11.2015
 * Time: 22:51
 */

namespace ICMS;


class File {

    private $fileID;
    private $fileName;
    private $filePath;
    private $ownerID;

    function __construct($fileID) {
        //construct from FileID
    }

    public function getFileID() {
        return $this->fileID;
    }

    public function getFileName() {
        return $this->fileName;
    }

    public function getOwner() {
        return User::fromUID($this->ownerID);
    }

    public function isUserActionAllowed($actionkey, $uID) {
        return false;
    }

    public function getLastVersion() {

    }
}