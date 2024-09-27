<form method="POST">
    <label>
        <input type="text" name="username">
    </label>
    <?php
    echo '<div>';
    echo isset($errors['username']) ?
    $errors['username']
    : '';
    echo '</div>';
    ?>
    <label>
        <input type="password" name="password">
    </label>
    <?php
    echo '<div>';
    echo isset($errors['password']) ?
    $errors['password']
    : '';
    echo '</div>';
    ?>
    <label>
        <select name="user_type">
            <option value="">Select User Type</option>
            <option value="admin">Admin</option>
            <option value="sales">Sales</option>
            <option value="customer">Customer</option>
        </select>
    </label>
    <?php
    echo '<div>';
    echo isset($errors['user_type']) ?
    $errors['user_type']
    : '';
    echo '</div>';
    ?>
    <label><input type="text" name="name"></label>
    <?php
    echo '<div>';
    echo isset($errors['name']) ?
    $errors['name']
    : '';
    echo '</div>';
    ?>
    <label>
        <textarea name="address" id="">

        </textarea>
    </label>
    <?php
    echo '<div>';
    echo isset($errors['address']) ?
    $errors['address']
    : '';
    echo '</div>';
    ?>
    <label><input type="text" name="email"></label>
    <?php
    echo '<div>';
    echo isset($errors['email']) ?
    $errors['email']
    : '';
    echo '</div>';
    ?>
    <div>
        <label>Male: <input type="radio" name="gender" value="male"></label>
        <label>Female: <input type="radio" name="gender" value="female"></label>    
    </div>
    <?php
    echo '<div>';
    echo isset($errors['gender']) ?
    $errors['gender']
    : '';
    echo '</div>';
    ?>
    <label>
        <input type="checkbox" name="terms">
        I accept Terms and conditions
    </label>
    <input type="submit" value="Submit" name="submit">
</form>