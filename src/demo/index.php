
<?php
    $content = '';
define('COURSES', ['iMsc IT', 'iMCA', 'BTech']);
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $errors = [];
    $name = $_POST['name'] ?? '';
    $roll_no = $_POST['roll_no'] ?? '';
    $currentCourse = $_POST['course'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $hobbies = explode(',', trim($_POST['hobbies'], ',') ?? '');
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';

    if (empty($name)) {
        $errors['name'] = 'Name should not be empty';
    }

    if (!empty($name) && !preg_match('/^[a-z ]{4,}$/i', $name)) {
        $errors['name'] = 'Invalid Name, Name must at least 4 characters long and should only contain alphabets';
    }

    if (empty($roll_no)) {
        $errors['roll_no'] = 'Roll No should not be empty';
    }
    if (!empty($roll_no) && !preg_match('/^[0-9]{1,}$/', $roll_no)) {
        $errors['roll_no'] = 'Roll No must be a number';
    }
    if (empty($currentCourse)) {
        $errors['course'] = 'Course should not be empty';
    }
    if (empty($gender)) {
        $errors['gender'] = 'gender should not be empty';
    }
    if (empty($hobbies[0])) {
        $errors['hobbies'] = 'Hobbies should not be empty';
    }
    if (empty($date)) {
        $errors['date'] = 'Date should not be empty';
    }
    // DD-MM-YYYY
    if (!empty($date) && !preg_match('/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/', $date)) {
        $errors['date'] = 'Invalid Date';
    }
    if (empty($time)) {
        $errors['time'] = 'time should not be empty';
    }
    // HH:MM(:SS)(Optional)
    if (!empty($time) && !preg_match('/^([0-9]{2})\:([0-9]{2})(:[0-9]{2})?$/', $time)) {
        $errors['time'] = 'Invalid Time';
    }
    if (!isset($_POST['terms'])) {
        $errors['terms'] = 'Please allow Terms and conditions';
    }
    if (empty($errors)) {
        $content = 'result.php';
    } else {
        $content = 'form.php';
    }
} else {
    $content = 'form.php';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <link rel="stylesheet" href="app.css">
</head>
<body>
    <?php include $content; ?> 

</body>
</html>