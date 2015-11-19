<?php

/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 08.10.2015
 * Time: 22:31
 */
class PDO_MYSQL {

    /**
     * Define global vars
     *
     * @var string host, pass, user, dbname
     * @var int port
     */
    private $host   = 'rdbms.strato.de';
    private $port   = 3306;
    private $pass   = 'bA2ZeRp0';
    private $user   = 'U2344370';
    private $dbname = 'DB2344370';

    /**
     * @return PDO PDO-Object
     */
    protected function connect() {
        return new PDO('mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->dbname,$this->user,$this->pass);
    }

    public function query($query, $array = []) {
        $db = $this->connect();
        $stmt = $db->prepare($query);
        if (!empty($array)) $stmt->execute($array);
        else $stmt->execute();

        return $stmt->fetchObject();
    }
}