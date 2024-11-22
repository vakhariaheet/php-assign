<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <form method="POST">
        <label for="">
            <input type="text" name="username" value="<?php echo $_COOKIE['username'] ?? ''?>">
        </label>
        <?php
        if (isset($error)) {
            echo '<div>';
            echo $error;
            echo '</div>';
        }

        ?>
        <input type="submit" value="Submit" name="submit">
    </form>
</body>
</html>