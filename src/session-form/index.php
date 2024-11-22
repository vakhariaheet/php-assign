<?php

setcookie('username', $name, time() + 60 * 10);
setcookie('password', $password, time() + 60 * 10);

echo $_COOKIE['username'];

if (isset($_SESSION['username']) && $_SESSION['expire'] > time()) {
    $_SESSION['expire'] = time() + 60 * 10;
    include 'result.php';
} elseif (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $error = '';
    if (empty($username)) {
        $error = 'Username is empty';
        include 'form.php';
    } else {
        $_SESSION['expire'] = time() + 60 * 10;
        $_SESSION['username'] = $username;

        include 'result.php';
    }
} else {
    include 'form.php';
}
