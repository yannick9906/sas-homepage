<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 20.02.2016
 * Time: 18:40
 */

namespace ICMS;

use PDO_MYSQL;

class Token {
    private $customerIP, $token, $tokenID, $validfrom, $active;

    /**
     * token constructor.
     * @param $customerIP
     * @param $token
     * @param $tokenID
     * @param $validfrom
     * @param $active
     */
    public function __construct($customerIP, $token, $tokenID, $validfrom, $active) {
        $this->customerIP = $customerIP;
        $this->token = $token;
        $this->tokenID = $tokenID;
        $this->validfrom = strtotime($validfrom);
        $this->active = $active;
    }

    /**
     * Returns a Token Object, based on a token from db
     *
     * @param $token
     * @return Token
     */
    public static function fromToken($token) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT * FROM tokens WHERE token = :token", [":token" => $token]);
        return new Token($res->IP, $res->token, $res->ID, $res->date, $res->active);
    }

    /**
     * Generates a new valid Token, false if no token can be generated
     *
     * return Token|boolean
     */
    public static function generateNewToken() {
        $pdo = new PDO_MYSQL();
        $customerIP = $_SERVER["REMOTE_ADDR"];
        $validfrom  = date("Y-m-d H:i:s");
        $token      = generateRandomString(32);
        if(!self::validTokenForIP($customerIP)) {
            $pdo->query("INSERT INTO tokens(token, IP, date, active) VALUES (:token, :ip, :date, 1)", [":token" => $token, ":ip" => $customerIP, ":date" => $validfrom]);
            $res = $pdo->query("SELECT * FROM tokens ORDER BY ID DESC LIMIT 1");
            return new Token($customerIP, $token, $res->ID, $validfrom, 1);
        } else return false;
    }

    public static function validTokenForIP($ip) {
        $pdo = new PDO_MYSQL();
        $res = $pdo->query("SELECT COUNT(*) as count FROM tokens WHERE IP = :ip and date >= now() - INTERVAL 1 DAY", [":ip" => $ip]);
        if($res->count == 1)
            return true;
        else
            return false;
    }

    public function checkIfValid() {
        if($this->customerIP == $_SERVER["REMOTE_ADDR"] and $this->validfrom >= strtotime('-24 hours') and $this->active == 1) {
            return true;
        } else return false;
    }

    public function useIt() {
        if($this->checkIfValid()) {
            $pdo = new PDO_MYSQL();
            $pdo->query("UPDATE tokens SET active = 0 WHERE token = :token", ["token" => $this->token]);
            return true;
        } else return false;
    }

    /**
     * @return mixed
     */
    public function getCustomerIP() {
        return $this->customerIP;
    }

    /**
     * @return mixed
     */
    public function getToken() {
        return $this->token;
    }
}
