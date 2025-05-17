<?php
namespace Portfolio;

require_once "database.php";

use Portfolio\Database;
use mysqli_sql_exception;

class QnA extends Database
{
    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function submitQuestion($email, $question)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO questions (email, question) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $question);
            $stmt->execute();
            $stmt->close();
            return "<div class='alert alert-success'>Your question was uploaded successfully</div>";
        } catch (mysqli_sql_exception $e) {
            return "<div class='alert alert-error'>" . $e->getMessage() . "</div>";
        }
    }

    public function getAnsweredQuestions()
    {
        try {
            $stmt = $this->db->prepare("SELECT answer, questions.question FROM answered_questions JOIN questions ON answered_questions.question_id = questions.id");
            $stmt->execute();
            $result = $stmt->get_result();
            $answeredQuestions = [];

            for ($i = 0; $i < $result->num_rows; $i++) {
                $row = $result->fetch_assoc();
                $answeredQuestions[] = $row;
            }

            $stmt->close();
            return $answeredQuestions;
        } catch (mysqli_sql_exception $e) {
            return "<div class='alert alert-error'>" . $e->getMessage() . "</div>";
        }
    }
}
?>