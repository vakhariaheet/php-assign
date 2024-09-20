<?php

require_once __DIR__ . '/../models/Student.php';
class HomeController
{
    public function handleRequest()
    {
        $student = new Student("", "", "", "", "", "", "");
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $student = new Student(
                $_POST['name'] ?? "",
                $_POST['roll_no']   ?? "",
                $_POST['course']   ?? "",
                $_POST['gender']  ?? "",
                $_POST['hobbies'] ? explode(",", trim($_POST['hobbies'], ',')) : "",
                $_POST['date'] ?? "",
                $_POST['time'] ?? ""
            );
            $student->validate();
            $errors = $student->getErrors();
            $is_terms_checked = isset($_POST['terms']);
            if (!$is_terms_checked) {
                $errors['terms'] = "Please agree to the terms and conditions";
            }
            if (empty($errors)) {
                $title = "Result";
                include __DIR__ . '/../views/result.php';
            } else {
                $title = "Form";
                include __DIR__ . '/../views/home.php';
            }
        } else {
            $title = "Form";
            include __DIR__ . '/../views/home.php';
        }
    }
}
