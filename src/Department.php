<?php
    class Department
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = (integer) $id;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO departments (name) VALUES ('{$this->getName()}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_departments = $GLOBALS['DB']->query("SELECT * FROM departments;");
            $departments = array();

            foreach($returned_departments as $department) {
            $name = $department['name'];
            $id = $department['id'];
            $new_department = new Department($name, $id);
            array_push($departments, $new_department);
            }
            return $departments;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM departments;");
        }

        static function find($search_id)
        {
            $found_department = null;
            $departments = Department::getAll();
            foreach($departments as $department) {
                $department_id = $department->getId();
                if ($department_id == $search_id) {
                  $found_department = $department;
                }
            }
            return $found_department;
        }

        function getCourses()
        {
            $returned_courses = $GLOBALS['DB']->query("SELECT courses.* FROM departments JOIN departments_courses ON (departments.id = departments_courses.department_id) JOIN courses ON (departments_courses.course_id = courses.id) WHERE department_id = {$this->getId()};");

            $courses = array();
            foreach($returned_courses as $course) {
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
            $GLOBALS['DB']->exec("INSERT INTO departments_courses (course_id, department_id) VALUES ({$course->getId()}, {$this->getId()});");
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM departments WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM departments_students WHERE department_id = {$this->getId()};");
        }

        public function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE departments SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function getStudents()
        {
            $returned_students = $GLOBALS['DB']->query("SELECT * FROM students WHERE department_id = {$this->getId()};");
            $students = array();
            foreach($returned_students as $student) {
                $name = $student['name'];
                $enrollment = $student['enrollment'];
                $id = $student['id'];
                $department_id = $student['department_id'];
                $new_student = new Student($name, $enrollment, $id, $department_id);
                array_push($students, $new_student);
            }
            return $students;
        }
    }

?>
