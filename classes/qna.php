<?php
namespace Portfolio\Entities;

require_once "database.php";

use Portfolio\Database;
use mysqli_sql_exception;

class QnA extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function submitQuestion($email, $question)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO questions (email, question) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $question);
            $stmt->execute();
            $stmt->close();
            return true;
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    public function submitAnswer($questionId, $answer)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO answered_questions (question_id, answer) VALUES (?, ?)");
            $stmt->bind_param("is", $questionId, $answer);
            $stmt->execute();
            $stmt->close();
            return true;
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    public function deleteQuestion($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM questions WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
            return true;
        } catch (mysqli_sql_exception $e) {
            return false;
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
            return null;
        }
    }
}
?>