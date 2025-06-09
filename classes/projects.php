<?php
namespace Portfolio\Entities;

require_once "database.php";

use Portfolio\Database;
use mysqli_sql_exception;

class Projects extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getProjects()
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM projects");
            $stmt->execute();
            $result = $stmt->get_result();
            $projects = [];

            for ($i = 0; $i < $result->num_rows; $i++) {
                $row = $result->fetch_assoc();
                $projects[] = $row;
            }

            $stmt->close();
            return $projects;
        } catch (mysqli_sql_exception $e) {
            return null;
        }
    }

    public function addProject($name, $description, $link, $is_featured = 0)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO projects (name, description, link, is_featured) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $name, $description, $link, $is_featured);
            $stmt->execute();
            $stmt->close();
            return true;
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    public function deleteProject($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM projects WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
            return true;
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    public function makeProjectFeatured($id)
    {
        try {
            $stmt = $this->db->prepare("UPDATE projects SET is_featured = 1 WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
            return true;
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }
}
?>