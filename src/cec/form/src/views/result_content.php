<div class="card_container">
	<div class="card">
		<div class="card_img_container">
			<img
				class="card_img"
				src="https://api.dicebear.com/9.x/avataaars-neutral/svg?seed=<?php echo $student->getName()?>"
				alt="Avatar"
				height="200"
				width="200"
			/>
		</div>
		<h1><?php echo $student->getName() ?></h1>
		<div class="card_items">
			<p class="card_roll_no"><?php echo $student->getRollNo() ?></p>
			<p class="card_course"><?php echo $student->getCourse() ?></p>
			<p class="card_gender"><?php echo ucfirst($student->getGender()) ?></p>
			<p class="card_timestamp">
				<?php echo $student->getDate() . " " . $student->getTime() ?>
			</p>
		</div>

		<h3>Hobbies:</h3>
		<ul>
			<?php foreach ($student->getHobbies() as $hobby) { echo "
			<li>$hobby</li>
			"; } ?>
		</ul>
        <form method="POST">
            <input type="submit" class="button" name="reset" value="Reset">
        </form>
	</div>
</div>
