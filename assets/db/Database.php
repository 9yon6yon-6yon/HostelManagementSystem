<?php

require('config.php');

class Database {
    private $db;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $this->db = new mysqli(DatabaseConfig::$host, DatabaseConfig::$username, DatabaseConfig::$password, DatabaseConfig::$dbname);

        if ($this->db->connect_error) {
            die("ERROR: Could not connect. " . $this->db->connect_error);
        }
    }

    public function getConnection() {
        return $this->db;
    }
}
