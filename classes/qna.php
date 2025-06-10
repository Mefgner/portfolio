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
            // Check if an answer already exists for this question
            $checkStmt = $this->db->prepare("SELECT id FROM answered_questions WHERE question_id = ?");
            $checkStmt->bind_param("i", $questionId);
            $checkStmt->execute();
            $result = $checkStmt->get_result();
            $existingAnswer = $result->fetch_assoc();
            $checkStmt->close();

            if ($existingAnswer) {
                // Update existing answer
                $stmt = $this->db->prepare("UPDATE answered_questions SET answer = ? WHERE question_id = ?");
                $stmt->bind_param("si", $answer, $questionId);
                $stmt->execute();
                $stmt->close();
                return true;
            }
            // If no existing answer, proceed to insert (original code)
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
            // First, delete any associated answer
            $stmt = $this->db->prepare("DELETE FROM answered_questions WHERE question_id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();

            // Then, delete the question
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
            $stmt = $this->db->prepare("SELECT aq.answer, q.question FROM answered_questions aq JOIN questions q ON aq.question_id = q.id WHERE aq.answer IS NOT NULL AND aq.answer!='' ORDER BY aq.id DESC");
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

    public function getAllQuestionsWithDetails()
    {
        try {
            $stmt = $this->db->prepare("
                SELECT 
                    q.id AS question_id, 
                    q.email AS question_email, 
                    q.question AS question_text, 
                    aq.answer AS answer_text 
                FROM 
                    questions q
                LEFT JOIN 
                    answered_questions aq ON q.id = aq.question_id
                ORDER BY 
                    q.id DESC 
            ");
            $stmt->execute();
            $result = $stmt->get_result();
            $questions = [];

            while ($row = $result->fetch_assoc()) {
                $questions[] = $row;
            }

            $stmt->close();
            return $questions;
        } catch (mysqli_sql_exception $e) {
            error_log("Error in getAllQuestionsWithDetails: " . $e->getMessage());
            return [];
        }
    }
}
?>