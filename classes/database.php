<?php
namespace Portfolio;

use mysqli;
class Database
{
    protected $db = null;
    public function __construct($db)
    {
        if (is_null($db) || $db == "" || empty($db)) {
            throw new \Exception("Database name cannot be null");
        }

        $file = file_get_contents("db_config.json");
        $json = json_decode($file, true);

        if (isset($json['host'])) {
            $host = $json['host'];
        } else {
            $host = "localhost";
        }
        if (isset($json['user'])) {
            $user = $json['user'];
        } else {
            $user = "root";
        }
        if (isset($json['password'])) {
            $password = $json['password'];
        } else {
            $password = "";
        }

        $this->db = $this->connect($db, $host, $user, $password);
    }
    private function connect($db, $host = "localhost", $user = "root", $password = "")
    {
        return new mysqli($host, $user, $password, $db);
    }

    public function __destruct()
    {
        $this->db->close();
    }
}
?>