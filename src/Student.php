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
    }
?>
