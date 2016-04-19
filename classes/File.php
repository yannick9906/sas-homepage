<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 19.11.2015
 * Time: 22:51
 */

namespace ICMS;

use PDO;
use \ICMS\PDO_MYSQL;

const FSORTING = [
    "ascName"  => " ORDER BY filename ASC",
    "ascID"    => " ORDER BY fID ASC",
    "ascDate"  => " ORDER BY date ASC",
    "descName" => " ORDER BY filename DESC",
    "descID"   => " ORDER BY fID DESC",
    "descDate" => " ORDER BY date DESC",
    "" => ""
];

const FFILTERING = [
    "Alle" => " ",
    "" => ""
];


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
    public static function fromFID($fID) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM schlopolis_files WHERE fID = :fid", [":fid" => $fID]);
        return new File($res->fID,$res->filename,$res->filepath,$res->ownerID,$res->uploaded);
    }

    /**
     * Deletes file from DB, but not from disk
     *
     * @return bool
     */
    public function deleteFile() {
        $pdo = new PDO_MYSQL();
        return $pdo->query("DELETE FROM schlopolis_files WHERE fID = :fid", [":fid" => $this->fileID]);
;    }

    /**
     * Returns the file name
     *
     * @return int
     */
    public function getFileID() {
        return $this->fileID;
    }

    /**
     * Returns the Name of the File
     *
     * @return string
     */
    public function getFileName() {
        return $this->fileName;
    }

    /**
     * Returns the absolute path to the file
     *
     * @return string
     */
    public function getFilePath() {
        return $this->filePath;
    }

    public function asArray() {
        return [
            "id" => $this->fileID,
            "title" => $this->fileName,
            "date" => $this->uploadedDate,
            "author" =>  User::fromUID($this->ownerID)->getPrefixAsHtml()." ".User::fromUID($this->ownerID)->getUName(),
            "filename" => $this->filePath
        ];
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
     * Returns an array of all File Objects
     *
     * @return File[]
     */
    public static function getAllFiles($sort = "", $filter = "") {
        $pdo = new PDO_MYSQL();
        $stmt = $pdo->queryMulti("SELECT fID FROM schlopolis_files ".FFILTERING[$filter].FSORTING[$sort]);
        return $stmt->fetchAll(PDO::FETCH_FUNC, "\\ICMS\\File::fromFID");
    }

    public static function getNextID() {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT MAX(fID) as fID FROM schlopolis_files");
        return $res->fID + 1;
    }

    /**
     * Creates a new File Entry in the db and moves the uploaded file to the desired directory
     * @param $filename string
     * @param $user User
     * @return File
     */

    public static function createFileAndMoveUploaded($filename, $user) {
        echo $pathToMvFile = "/mnt/web010/b0/98/56883098/htdocs/uploads/".self::getNextID()."_".$_FILES['file']['name'];
        $absolutePath = "http://schlopolis.de/uploads/".self::getNextID()."_".$_FILES['file']['name'];
        $pdo = new PDO_MYSQL();
        $ownerID = $user->getUID();
        $date = date("Y-m-d H:i:s");

        var_dump($_FILES["file"]);
        if(move_uploaded_file($_FILES['file']['tmp_name'], $pathToMvFile)) {
            $pdo->query("INSERT INTO schlopolis_files (filename, filepath, ownerID, uploaded) VALUES (:name, :path, :owner, :date)", [":name" => $filename, ":path" => $absolutePath, ":owner" => $ownerID, ":date" => $date]);
            echo "OK";
            return File::fromFID(self::getNextID()-1);
        } else return false;

    }
}