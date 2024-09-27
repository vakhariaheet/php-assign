<main>
    <form method="POST">
        <label>
            <span> Roll No. </span>
            <input type="text" placeholder="Enter Roll No." name="roll_no" value="<?php echo $roll_no ?? ''; ?>"
             />
        </label>
        <?php
        if (isset($errors['roll_no'])) {
            echo '<div class=\'error\'>'.$errors['roll_no'].'</div>';
        }
            ?>
        <label>
            <span> Name </span>
            <input type="text" placeholder="Enter Name" name="name" value="<?php echo $name ?? ''; ?>" />

        </label>
        <?php
            if (isset($errors['name'])) {
                echo '<div class=\'error\'>'.$errors['name'].'</div>';
            }
            ?>
        <label>
            <span> Course </span>
           
            <select name="course" placeholder="Select a course" id="">
                <option value="">Select a Course</option>
               
                <?php
                foreach (constant('COURSES') as $course) {
                    echo '<option value=\''.$course.'\' '.($course === $currentCourse ? 'selected' : '').'>'.$course.'</option>';
                }

            ?>
                
            </select>
        </label>
        <?php
            if (isset($errors['course'])) {
                echo '<div class=\'error\'>'.$errors['course'].'</div>';
            }
            ?>
        <div class="label">
            <span> Gender </span>
            <label for="male">
                Male: <input type="radio" name="gender" value="male" id="male" <?php echo ($gender ?? '') == 'male' ? 'checked' : ''; ?>>
            </label>
            <label for="female">
                Female: <input type="radio" name="gender" value="female" id="female"  <?php echo ($gender ?? '') === 'female' ? 'checked' : ''; ?>>
            </label>
        </div>
        <?php
            if (isset($errors['gender'])) {
                echo '<div class=\'error\'>'.$errors['gender'].'</div>';
            }
            ?>
        <label>
            <span> Hobbies </span>
            <input type="text" placeholder="Enter Hobbies (Comma Separated)" name="hobbies" value="<?php echo isset($hobbies) ? implode(',', $hobbies) : ''; ?>" />
        </label>
        <?php
                if (isset($errors['hobbies'])) {
                    echo '<div class=\'error\'>'.$errors['hobbies'].'</div>';
                }
            ?>
        <label>
            <span> Date </span>
            <input type="text" placeholder="Enter Date (Format: DD/MM/YYYY)" name="date" value="<?php echo $date ?? ''; ?>" />
        </label>
        <?php
            if (isset($errors['date'])) {
                echo '<div class=\'error\'>'.$errors['date'].'</div>';
            }
            ?>
        <label>
            <span> Time </span>
            <input type="text" placeholder="Enter Time (Format: HH:MM)" name="time" value="<?php echo $time ?? ''; ?>" />
        </label>
        <?php
            if (isset($errors['time'])) {
                echo '<div class=\'error\'>'.$errors['time'].'</div>';
            }
            ?>
        <label>
            <input type="checkbox" name="terms" />
            <span> I agree to the terms and conditions </span>
        </label>
        <?php
            if (isset($errors['terms'])) {
                echo '<div class=\'error\'>'.$errors['terms'].'</div>';
            }
            ?>
        <button name="submit">Submit</button>
    </form>
</main>