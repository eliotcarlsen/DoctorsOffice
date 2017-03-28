<?php
  class Doctor
  {
      private $name;
      private $specialty;
      private $id;

      function __construct ($name, $specialty, $id = null)
      {
          $this->name = $name;
          $this->specialty = $specialty;
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
      function setSpecialty($new_specialty)
      {
          $this->specialty = $new_specialty;
      }
      function getSpecialty()
      {
          return $this->specialty;
      }
      function getId()
      {
          return $this->id;
      }

      function save()
      {
          $executed = $GLOBALS['DB']->exec("INSERT INTO doctors (name,specialty) VALUES ('{$this->getName()}','{$this->getSpecialty()}');");
          if ($executed){
              $this->id = $GLOBALS['DB']->lastInsertId();
              return true;
          } else {
              return false;
          }
      }

      static function getAll(){
        $returned = $GLOBALS['DB']->query("SELECT * FROM doctors;");
        $results = $returned->fetchAll(PDO::FETCH_OBJ);
        return $results;
      }

      static function find($id){
        $returned = $GLOBALS['DB']->prepare("SELECT * FROM doctors WHERE id = :id;");
        $returned->bindParam(':id', $id, PDO::PARAM_STR);
        $returned->execute();
        $result = $returned->fetch(PDO::FETCH_ASSOC);
        if($result['id'] == $id ){
          $found_doctor = new Doctor($result['name'], $result['specialty'], $result['id']);
        }
        return $found_doctor;
      }
  }
?>
