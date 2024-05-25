<?php

namespace database;

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'db_lspu_blog');

class Database {
    private $connection;

    public function __construct() {
        $this->connection = new \mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}
?>