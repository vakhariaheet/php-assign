<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users</title>
</head>
<body>
    
    <table>
        <tr>
            <th>Name</th>
            <th>Username</th>
            <th>Password</th>
            <th>Action</th>
        </tr>
        

        <?php
            while ($user = mysqli_fetch_assoc($allUsers)) {
                echo '<tr>';
                echo '<td>'.$user['name'].'</td>';
                echo '<td>'.$user['username'].'</td>';
                echo '<td>'.$user['password'].'</td>';
                echo '<td>';
                echo '<form method="POST">';
                echo '<input type="hidden" name="username" value="'.$user['username'].'">';
                echo '<button type="submit" name="delete">Delete</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
        ?>

    </table>
</body>
</html>