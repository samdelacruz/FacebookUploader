<?php

namespace Uploader\Utils;

/**
 * Class DatabaseAdapter
 * MySQL implementation of iDatabaseAdapter
 * @package Uploader\Utils
 */
class DatabaseAdapter implements iDatabaseAdapter{
    private $dbhost;
    private $dbPort;
    private $username;
    private $password;
    private $dbName;
    private $tableName;

    /**
     * Constructor for DatabaseAdapter
     * Creates Database and/or Table if they do not exist.
     * @param $dbhost
     * @param $dbPort
     * @param $username
     * @param $password
     * @param $dbName
     * @param $tableName
     */
    public function __construct($dbhost, $dbPort, $username, $password, $dbName, $tableName) {
        if(is_string($dbhost) && is_numeric($dbPort) && is_string($username) && is_string($password)
            && is_string($dbName) && is_string($tableName)) {

            $this->dbhost = $dbhost;
            $this->dbPort = $dbPort;
            $this->username = $username;
            $this->password = $password;
            $this->dbName = $dbName;
            $this->tableName = $tableName;

            $conn = new \mysqli($this->dbhost, $this->username, $this->password, "", $dbPort);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $this->createDBIfNotExists($conn);
            $conn->close();
            $conn = new \mysqli($this->dbhost, $this->username, $this->password, $this->dbName, $this->dbPort);
            $this->createTableIfNotExists($conn);
            $conn->close();
        }
    }

    /**
     * Log a message, ip address and timestamp to database
     * @param $message
     * @param $ipAddress
     * @param $timestamp
     * @return bool|string
     */
    public function logToDatabase($message, $ipAddress, $timestamp) {
        $conn = new \mysqli($this->dbhost, $this->username, $this->password, $this->dbName, $this->dbPort);
        $query = "INSERT INTO $this->tableName (message, ip_address, date_posted ) VALUES ('$message', '$ipAddress', FROM_UNIXTIME($timestamp))";
        if($conn->query($query) === true) {
            return true;
        } else {
            return $conn->error;
        }
    }

    /**
     * Creates database if it doesn't exist.
     * @param $conn Database connection
     */
    private function createDBIfNotExists($conn) {
        $query = "CREATE DATABASE IF NOT EXISTS $this->dbName";
        $conn->query($query);
    }

    /**
     * Create table if it doesn't exist.
     * @param $conn Database connection
     */
    private function createTableIfNotExists($conn) {
        $query = "CREATE TABLE IF NOT EXISTS $this->tableName ( "
            . "id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, "
            . "message VARCHAR(420) NOT NULL, "
            . "ip_address VARCHAR(39) NOT NULL, "
            . "date_posted DATETIME NOT NULL )";
        $conn->query($query);
    }

}