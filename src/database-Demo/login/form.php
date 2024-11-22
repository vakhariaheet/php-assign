<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        label{
            display: block;
        }

    </style>
</head>
<body>
    <form method="POST">
        <label>
            Username: <input type="text" name="username" value="<?php echo $_COOKIE['username'] ?? ''; ?>">
        </label>
        <label>
            Password: <input type="password" name="password" value="<?php echo $_COOKIE['password'] ?? ''; ?>">
        </label>
        <label >
           <input type="checkbox" name="remember" id=""> Remember me
        </label>
        <button type="submit" name="submit">Login</button>
        <span>
            <?php
                if (isset($errors['global'])) {
                    echo $errors['global'];
                }
            ?>
        </span>
    </form>
</body>
</html>