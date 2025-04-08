<?php
namespace Portfolio;

use mysqli;
class Database
{
    protected $db = null;
    public function __construct($db)
    {
        $this->db = $this->connect($db);
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