<?php
  require_once "src/Doctor.php";

  class DoctorTest extends PHPUnit_Framework_TestCase {
    function testDoctor () {
      //Arrange
      $test_class = new Doctor;
      $input = "";
      //Act
      $result = $test_class->methode();
      //Assert
      $this->assertEquals(" ", $result);
    }
  }

?>
