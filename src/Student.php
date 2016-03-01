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

        static function find($search_id)
        {
            $found_student = null;
            $students = Student::getAll();
            foreach($students as $student) {
                $student_id = $student->getId();
                if ($student_id == $search_id) {
                  $found_student = $student;
                }
            }
            return $found_student;
        }

        function getCourses()
        {
            $query = $GLOBALS['DB']->query("SELECT courses.* FROM students JOIN students_courses ON (students.id = students_courses.student_id) JOIN courses ON (students_courses.course_id = courses.id) WHERE student_id = {$this->getId()};");

            $course_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $courses = array();
            foreach($course_ids as $course) {
                $name = $course['name'];
                $course_number = $course['course_number'];
                $id = $course['id'];
                $new_course = new Course($name, $course_number, $id);
                array_push($courses, $new_course);
            }
            return $courses;
        }
        function addCourse($course)
        {
            $GLOBALS['DB']->exec("INSERT INTO students_courses (course_id, student_id) VALUES ({$course->getId()}, {$this->getId()});");
        }


    }
?>
