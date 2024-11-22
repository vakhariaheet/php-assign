<?php

// 1. Simple form Print
// 2. Form Submitted

if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $error = '';
    if (empty($name) || empty($id) || empty($username) || empty($password)) {
        $error = 'Please enter all the fields';
    }
    $hostname = 'sql202.ezyro.com'; // localhost
    $user = 'ezyro_37339395'; // php
    $dbpassword = 'd0039f8dee4'; // php
    $database = 'ezyro_37339395_demo';

    $con = mysqli_connect($hostname, $user, $dbpassword, $database);
    if ($con == null) {
        exit('Error connecting to db'.mysqli_connect_error());
    }
    $qry = "UPDATE users SET password='$password', username='$username' , name='$name' WHERE id = '$id' ;";

    $result = mysqli_query($con, $qry);
    if ($result == null) {
        exit('Error connecting to db'.mysqli_error($con));
    }
    include 'result.php';
} else {
    include 'form.php';
}
