<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
       label{
        display: block;
       }
       input{
        padding: 1rem;
       }
    </style>
</head>
<body>
    <form method="POST">
        <label>
            Name: <input type="text" name="name" />
        </label>
        <span>
            <?php
                echo isset($errors['name']) ? $errors['name'] : '';
            ?>
        </span>
        <label>
            Username: <input type="text" name="username">
        </label>
        <span>
            <?php
            echo isset($errors['username']) ? $errors['username'] : '';
            ?>
        </span>
        <label>
            Password: <input type="password" name="password">
        </label>
        <span>
            <?php
            echo isset($errors['password']) ? $errors['password'] : '';
            ?>
        </span>
        <button type="submit" name="submit">Login</button>
        <span>
            <?php
            echo isset($errors['global']) ? $errors['global'] : '';
            ?>
        </span>
    </form>
</body>
</html>