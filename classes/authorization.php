<?php
namespace Portfolio;

require_once "database.php";

use Portfolio\Database;
use mysqli_sql_exception;

class Authorization extends Database
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        parent::__construct();
    }

    public function __destruct()
    {
        session_write_close();
    }

    public function login($username, $password)
    {
        if (empty($username) || empty($password)) {
            return false;
        }
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE name = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                echo $user['hashed_password'];
                echo $user;
                if (password_verify($password, $user['hashed_password'])) {
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'is_admin' => $user['is_admin']
                    ];
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    public function isLoggedIn()
    {
        if (!isset($_SESSION['user'])) {
            return false;
        }

        try {
            if (isset($_SESSION['user'])) {
                $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
                $stmt->bind_param("i", $_SESSION['user']['id']);
                $stmt->execute();
                $result = $stmt->get_result();

                return $result->num_rows > 0;
            }
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    public function isAdmin()
    {
        if (!isset($_SESSION['user'])) {
            return false;
        }

        if (!$this->isLoggedIn()) {
            return false;
        }

        try {
            if (isset($_SESSION['user'])) {
                $stmt = $this->db->prepare("SELECT is_admin FROM users WHERE id = ?");
                $stmt->bind_param("i", $_SESSION['user']['id']);
                $stmt->execute();
                $result = $stmt->get_result()->fetch_assoc();

                return $result['is_admin'] === 1;
            }
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    public function register($username, $password)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $this->db->prepare("INSERT INTO users (name, hashed_password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $password);
            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    public function logout()
    {
        session_start();
        $_SESSION = [];
        session_destroy();
    }
}
?>