<?php

require_once __DIR__.'/../modals/User.php';
class RegisterController
{
    public function handleRequest()
    {
        $user = new User('', '', '', '', '', '', '');
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $user = new User(
                $_POST['name'] ?? '',
                $_POST['username'] ?? '',
                $_POST['password'] ?? '',
                $_POST['address'] ?? '',
                $_POST['email'] ?? '',
                $_POST['user_type'] ?? '',
                $_POST['name'] ?? '',
            );
            $errors = $user->validate();
            print_r($_POST['address']);
            echo 'Heeelloo: '.$user->getAddress().$_POST['address'].(empty($_POST['address']) ? 'True' : 'False');
            if (empty($errors)) {
                $title = 'Result';
                include __DIR__.'/../views/result.php';
            } else {
                $title = 'Form';
                include __DIR__.'/../views/home.php';
            }
        } else {
            $title = 'Home';
            include __DIR__.'/../views/home.php';
        }
    }
}
