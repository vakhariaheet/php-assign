<?php

function initDB()
{
    $hostname = 'sql202.ezyro.com'; // localhost
    $user = 'ezyro_37339395'; // php
    $password = 'd0039f8dee4'; // php
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
function checkUsername($con, $username)
{
    $getUserQuery = 'SELECT username FROM users WHERE username = \''.$username.'\';';

    $result = mysqli_query($con, $getUserQuery);
    if (mysqli_num_rows($result) > 0) {
        return false;
    } else {
        return true;
    }
}

function createUser($con, $name, $username, $password)
{
    $query = 'INSERT INTO users(username,password,name) VALUES(\''.$username.'\',\''.$password.'\',\''.$name.'\')';
    $result = mysqli_query($con, $query);
    if ($result == null) {
        exit('Errorrrr'.mysqli_error($con));
    }
}
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $errors = [];

    if (empty($name) || empty($username) || empty($password)) {
        $errors['global'] = 'Please Fill All Fields';
    }
    if (!empty($name) && !preg_match('/^[a-z A-Z]+$/', $name)) {
        $errors['name'] = 'Invalid Name';
    }
    if (!empty($username) && !preg_match("/^[\.a-z0-9_-]+$/", $username)) {
        $errors['username'] = 'Invalid username';
    }
    if (!empty($password) && !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@#$%\^&*!])(.{8,})$/', $password)) {
        $errors['password'] = 'Invalid Password';
    }
    if (!empty($username) && preg_match("/^[\.a-z_-]+$/", $username)) {
        $isUserValid = checkUsername($con, $username);
        if (!$isUserValid) {
            $errors['username'] = 'Username already Exists';
        }
    }

    if (!empty($errors)) {
        include 'form.php';
    } else {
        createUser($con, $name, $username, $password);
        $usersQuery = 'SELECT * FROM users';
        $allUsers = mysqli_query($con, $usersQuery);
        include 'result.php';
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
