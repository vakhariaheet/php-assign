<?php

session_start();
function initDB()
{
    $hostname = 'sql202.ezyro.com';
    $user = 'ezyro_37339395';
    $password = 'd0039f8dee4';
    $database = 'ezyro_37339395_demo';

    $con = mysqli_connect($hostname, $user, $password, $database);

    if ($con == null) {
        exit('Error In connecting DB '.mysqli_connect_error());
    }

    $createTableQuery = '
        CREATE TABLE IF NOT EXISTS users(
            id INT PRIMARY KEY AUTO_INCREMENT,
            username VARCHAR(50) NOT NULL,
            password VARCHAR(50) NOT NULL,
            name VARCHAR(50) NOT NULL
        );
    ';
    $result = mysqli_query($con, $createTableQuery);
    if ($result == null) {
        exit('Error In connecting DB '.mysqli_connect_error());
    }

    return $con;
}
$con = initDB();

if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = $_POST['remember'] ?? '';
    $errors = [];
    if (empty($username) || empty($password)) {
        $errors['global'] = 'Please Enter all the details';
    } else {
        $checkQuery = 'SELECT * FROM users WHERE username = \''.$username.'\' AND password = \''.$password.'\';';

        $result = mysqli_query($con, $checkQuery);
        if ($result == null) {
            exit('Erroorrrr'.mysqli_error($con));
        }
        if (mysqli_num_rows($result) == 0) {
            $errors['global'] = 'Invalid Credentials';
        }
    }
    if (empty($errors)) {
        if ($remember) {
            setcookie('username', $username, time() * 10);
            setcookie('password', $password, time() * 10);
        }
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;

        $usersQuery = 'SELECT * FROM users';
        $allUsers = mysqli_query($con, $usersQuery);
        include 'result.php';
    } else {
        include 'form.php';
    }
} elseif (isset($_POST['delete']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $deleteUserQuery = 'DELETE FROM users WHERE username = "'.$_POST['username'].'"';
    $result = mysqli_query($con, $deleteUserQuery);
    if ($result == null) {
        exit('Error in Deleting user'.mysqli_error($con));
    }

    $usersQuery = 'SELECT * FROM users';
    $allUsers = mysqli_query($con, $usersQuery);
    include 'result.php';
} else {
    include 'form.php';
}
session_unset();
session_destroy();
