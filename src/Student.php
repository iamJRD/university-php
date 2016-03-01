<?php
    class Student
    {
        private $name;
        private $enrollment;
        private $id;

        function __construct($name, $enrollment, $id=null)
        {
            $this->name = $name;
            $this->enrollment = $enrollment;
            $this->id = $id;
        }
        function setName($new_name)
        {
            $this->name = $new_name;
        }
        function getName()
        {
            return $this->name;
        }
        function setEnrollment($new_enrollment)
        {
            $this->enrollment = $new_enrollment;
        }
        function getEnrollment()
        {
            return $this->enrollment;
        }
        function getId()
        {
            return $this->id;
        }
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO students (name, enrollment) VALUES ('{$this->getName()}','{$this->getEnrollment()}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_students = $GLOBALS['DB']->query("SELECT * FROM students;");
            $students = array();

            foreach($returned_students as $student) {
            $name = $student['name'];
            $enrollment = $student['enrollment'];
            $id = $student['id'];
            $new_student = new Student($name, $enrollment, $id);
            array_push($students, $new_student);
            }
            return $students;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM students;");
        }
    }
?>
