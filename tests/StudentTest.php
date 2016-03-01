<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Student.php";

    $server = 'mysql:host=localhost;dbname=university_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StudentTest extends PHPUnit_Framework_TestCase
    {
        function testGetName()
        {
            //Arrange
            $name = "Joe";
            $enrollment = "2016-03-01";
            $test_student = new Student($name, $enrollment);

            //Act
            $result = $test_student->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function testGetEnrollment()
        {
            // Arrange
            $name = "Joe";
            $enrollment = "2016-03-01";
            $test_student = new Student($name, $enrollment);

            // Act
            $result = $test_student->getEnrollment();

            // Assert
            $this->assertEquals($enrollment, $result);
        }
    }
?>
