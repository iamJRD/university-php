<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Course.php";

    $server = 'mysql:host=localhost;dbname=university_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CourseTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Course::deleteAll();
        }

        function testGetName()
        {
            // Arrange
            $name = "Intro to Programming";
            $course_number = "PROG101";
            $test_course = new Course($name, $course_number);

            // Act
            $result = $test_course->getName();

            // Assert
            $this->assertEquals($name, $result);
        }

        function testGetCourseNumber()
        {
            // Arrange
            $name = "Intro to Programming";
            $course_number = "PROG101";
            $test_course = new Course($name, $course_number);

            // Act
            $result = $test_course->getCourseNumber();

            // Assert
            $this->assertEquals($course_number, $result);
        }

        function testGetId()
        {
            // Arrange
            $name = "Intro to Programming";
            $course_number = "PROG101";
            $id = 1;
            $test_course = new Course($name, $course_number, $id);

            // Act
            $result = $test_course->getId();

            // Assert
            $this->assertEquals($id, $result);
        }

        function testSave()
        {
            //Arrange
            $name = "Intro to Programming";
            $course_number = "PROG101";
            $test_course = new Course($name, $course_number);
            $test_course->save();

            //Act
            $result = Course::getAll();

            //Assert
            $this->assertEquals($test_course, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
            $name = "Intro to Programming";
            $course_number = "PROG101";
            $id = 1;
            $test_course = new Course($name, $course_number, $id);
            $test_course->save();

            $name2 = "History";
            $course_number2 = "HIST101";
            $id2 = 2;
            $test_course2 = new Course($name2, $course_number2, $id2);
            $test_course2->save();

            //Act
            $result = Course::getAll();
            //Assert
            $this->assertEquals([$test_course, $test_course2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "Intro to Programming";
            $course_number = "PROG101";
            $id = 1;
            $test_course = new Course($name, $course_number, $id);
            $test_course->save();

            $name2 = "History";
            $course_number2 = "HIST101";
            $id2 = 2;
            $test_course2 = new Course($name2, $course_number2, $id2);
            $test_course2->save();

            //Act
            Course::deleteAll();
            $result = Course::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function testFind()
       {
         //Arrange;
         $name = "Intro to Programming";
         $course_number = "PROG101";
         $id = 1;
         $test_course = new Course($name, $course_number, $id);
         $test_course->save();

         $name2 = "History";
         $course_number2 = "HIST101";
         $id2 = 2;
         $test_course2 = new Course($name2, $course_number2, $id2);
         $test_course2->save();

         //Act;
         $result = Course::find($test_course->getId());

         //Assert
         $this->assertEquals($test_course, $result);
       }
    }
?>
