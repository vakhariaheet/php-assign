<?php

class Student
{
    private $name;
    private $roll_no;
    private $course;
    private $gender;

    private $hobbies = [];
    private $date;
    private $time;

    private $errors = [];
    public function __construct($name, $roll_no, $course, $gender, $hobbies, $date, $time)
    {
        $this->name = $name;
        $this->roll_no = $roll_no;
        $this->course = $course;
        $this->gender = $gender;
        $this->hobbies = $hobbies;
        $this->date = $date;
        $this->time = $time;
    }


    public function getName()
    {
        return $this->name;
    }

    public function getRollNo()
    {
        return $this->roll_no;
    }

    public function getCourse()
    {
        return $this->course;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getHobbies()
    {
        return $this->hobbies;
    }
    public function getHobbiesAsString()
    {
        if (empty($this->hobbies[0])) {
            return "";
        }

        return implode(",", $this->hobbies);
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function getErrors()
    {
        return $this->errors;
    }
    public function validate()
    {
        $this->errors = [];
        if(empty($this->name)) {
            $this->errors['name'] = "Name Should not be empty";
        }
        if(!empty($this->name) && !preg_match('/^[a-z ]+$/i', $this->name)) {
            $this->errors['name'] = "Name should only contain characters";
        }
        if(empty($this->roll_no)) {

            $this->errors['roll_no'] = "Roll No. Should not be empty";
        }
        if(!empty($this->roll_no) && !preg_match('/^\d+$/', $this->roll_no)) {
            $this->errors['roll_no'] = "Roll No. should only contain digits";
        }

        if(empty($this->course)) {
            $this->errors['course'] = "Course Should not be empty";
        }
        if (empty($this->gender)) {
            $this->errors['gender'] = "Gender Should not be empty";
        }
        if (empty($this->hobbies[0])) {
            $this->errors['hobbies'] = "Hobbies Should not be empty";
        }
        if (empty($this->date)) {
            $this->errors['date'] = "Date Should not be empty";
        }
        if (!empty($this->date) && !preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $this->date)) {
            $this->errors['date'] = "Date should be in DD/MM/YYYY format";
        }
        if (!empty($this->date) &&  preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $this->date)) {
            $date = explode("/", $this->date);
            $day = $date[0];
            $month = $date[1];
            $year = $date[2];
            if (!checkdate($month, $day, $year)) {
                $this->errors['date'] = "Date is invalid";
            }
        }



        if (empty($this->time)) {
            $this->errors['time'] = "Time Should not be empty";
        }

        if (!empty($this->time) && !preg_match('/^\d{1,2}:\d{1,2}(:\d{1,2})*$/', $this->time)) {
            $this->errors['time'] = "Time should be in HH:MM format";
        }
        if (!empty($this->time) && preg_match('/^\d{1,2}:\d{1,2}(:\d{1,2})*$/', $this->time)) {
            $time = explode(":", $this->time);
            $hour = (int)$time[0];
            $mins = (int)$time[1];
            $sec = (int)(count($time) == 3 ? $time[2] : "00");
            if($hour > 24 || $mins > 60 || $sec > 60 || $hour < 0 || $mins < 0 || $sec < 0) {
                $this->errors['time'] = 'Invalid Time';
            }
        }

    }


}
