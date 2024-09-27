<main>
    <form method="POST">

        <label>
            <span> Roll No. </span>
            <input type="text" placeholder="Enter Roll No." name="roll_no"
                value="<?php echo $student->getRollNo() ?>" />
        </label>
        
            <?php if (isset($errors['roll_no'])) {
                printError($errors['roll_no']);
            } ?>
        
        <label>
            <span> Name </span>
            <input type="text" placeholder="Enter Name" name="name" value="<?php echo $student->getName() ?>" />

        </label>
        
            <?php if (isset($errors['name'])) {
                printError($errors['name']);
            } ?>
       
        <label>
            <span> Course </span>
            <select name="course" placeholder="Select a course" id="">
                <option value=""> Select a Course </option>
                <?php foreach (constant('POSSIBLE_COURSES') as $course) {
                    echo "<option value='$course' " . ($student->getCourse() === $course ? "selected" : "") . ">$course</option>";
                } ?>
            </select>


        </label>
        
            <?php if (isset($errors['course'])) {
                printError($errors['course']);
            } ?>
        
        <div class="label">
            <span> Gender </span>
            <?php $student->getGender()
            ?>
            <?php foreach (constant('POSSIBLE_GENDER') as $gender) {
                echo "<label><input type='radio' name='gender' value='$gender'" . ($gender === $student->getGender() ? "checked" : "") . " 
                /> ". ucfirst($gender) ." </label>";
            } ?>

        </div>
        
            <?php if (isset($errors['gender'])) {
                printError($errors['gender']);
        }?>
        
        <label>
            <span> Hobbies </span>
            <input type="text" placeholder="Enter Hobbies (Comma Separated)" name="hobbies"
                value="<?php echo $student->getHobbiesAsString() ?>" />

        </label>
        
            <?php if (isset($errors['hobbies'])) {
                printError($errors['hobbies']);
        } ?>
        
        <label>
            <span> Date </span>
            <input type="text" placeholder="Enter Date (Format: DD/MM/YYYY)" name="date"
                value="<?php echo $student->getDate() ?>" />

        </label>
       
            <?php if (isset($errors['date'])) {
                printError($errors['date']);
            } ?>
        </div>
        <label>
            <span> Time </span>
            <input type="text" placeholder="Enter Time (Format: HH:MM)" name="time"
                value="<?php echo $student->getTime() ?>" />

        </label>
        
            <?php if (isset($errors['time'])) {
                printError($errors['time']);
            } ?>
        
        <label>
            <input type="checkbox" name="terms">
            <span> I agree to the terms and conditions </span>
        </label>
        
            <?php if (isset($errors['terms'])) {
                printError($errors['terms']);
        } ?>
       
        <button name="submit"> Submit </button>
    </form>
</main>