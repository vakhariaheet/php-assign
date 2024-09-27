<?php

class User
{
    private $username;
    private $password;
    private $address;
    private $email;
    private $name;
    private $gender;
    private $user_type;

    public function __construct($name, $username, $password, $address, $email, $user_type, $gender)
    {
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
        $this->address = $address;
        $this->gender = $gender;
        $this->user_type = $user_type;
        $this->email = $email;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getUserType()
    {
        return $this->user_type;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function validate()
    {
        $errors = [];

        if (empty($this->name)) {
            $errors['name'] = 'Please enter name';
        }
        if (!empty($this->name) && !preg_match('/^[a-z ]+$/i', $this->name)) {
            $errors['name'] = 'Invalid Name';
        }

        if (empty($this->username)) {
            $errors['username'] = 'Please enter username';
        }

        if (!empty($this->username) && !preg_match('/^[a-z_.-0-9]+$/i', $this->name)) {
            $errors['username'] = 'Invalid username';
        }

        if (empty($this->password)) {
            $errors['password'] = 'Please enter password';
        }

        if (empty($this->email)) {
            $errors['email'] = 'Please enter email';
        }

        if (!empty($this->email) && !preg_match('/^\w+@\w+(\.\w{2,5})+/', $this->name)) {
            $errors['email'] = 'Invalid email';
        }

        if (empty($this->address)) {
            echo 'fdskafjfsdl';
            $errors['address'] = 'Please enter address';
        }

        if (empty($this->user_type)) {
            $errors['user_type'] = 'Please select user type';
        }

        if (empty($this->gender)) {
            $errors['gender'] = 'Please select gender';
        }

        return $errors;
    }
}
