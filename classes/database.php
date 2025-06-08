<?php
namespace Portfolio;

use mysqli;
class Database
{
    protected $db;
    public function __construct()
    {
        $file = file_get_contents("db_config.json");
        $json = json_decode($file, true);

        $configFilePath = __DIR__ . '/../db_config.json';

        if (!file_exists($configFilePath)) {
            $resolvedPath = realpath($configFilePath) ?: $configFilePath;
            throw new \RuntimeException("Database configuration file not found: " . $resolvedPath);
        }

        $configJson = file_get_contents($configFilePath);
        if ($configJson === false) {
            $resolvedPath = realpath($configFilePath) ?: $configFilePath;
            throw new \RuntimeException("Unable to read database configuration file: " . $resolvedPath);
        }

        $dbConfigData = json_decode($configJson, true); // 'true' for an associative array

        if (json_last_error() !== JSON_ERROR_NONE) {
            $resolvedPath = realpath($configFilePath) ?: $configFilePath;
            throw new \RuntimeException("Error parsing JSON from database configuration file (" . $resolvedPath . "): " . json_last_error_msg());
        }

        $this->db = $this->connect(
            $dbConfigData['database'] ?? 'portfolio',
            $dbConfigData['host'] ?? 'localhost',
            $dbConfigData['user'] ?? 'root',
            $dbConfigData['password'] ?? ''
        );
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