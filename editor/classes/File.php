<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 19.11.2015
 * Time: 22:51
 */

namespace ICMS;


use PDO;
use PDO_MYSQL;

class File {

    private $fileID;
    private $fileName;
    private $filePath;
    private $ownerID;
    private $uploadedDate;

    /**
     * File constructor.
     * @param $fileID
     * @param $fileName
     * @param $filePath
     * @param $ownerID
     * @param $uploadedDate
     */
    public function __construct($fileID, $fileName, $filePath, $ownerID, $uploadedDate) {
        $this->fileID = $fileID;
        $this->fileName = $fileName;
        $this->filePath = $filePath;
        $this->ownerID = $ownerID;
        $this->uploadedDate = $uploadedDate;
    }

    /**
     * Creates a new File object based on db data
     *
     * @param $fID
     * @return File
     */
    public function fromFID($fID) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM schlopolis_files WHERE fID = :fid", [":fid" => $fID]);
        return new File($res->fID,$res->filename,$res->filepath,$res->ownerID,$res->uploaded);
    }

    public function deleteFile() {

    }

    /**
     * @return int
     */
    public function getFileID() {
        return $this->fileID;
    }

    /**
     * @return string
     */
    public function getFileName() {
        return $this->fileName;
    }

    /**
     * @return string
     */
    public function getFilePath() {
        return $this->filePath;
    }

    /**
     * Returns the owner as a User object
     *
     * @return User
     */
    public function getOwner() {
        return User::fromUID($this->ownerID);
    }

    /**
     * @return File[]
     */
    public static function getAllFiles() {

    }

    /**
     * Creates a new File Entry in the db and moves the uploaded file to the desired directory
     */
    public static function createFileAndMoveUploaded() {

    }
}