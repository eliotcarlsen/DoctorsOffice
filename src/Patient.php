<?php
    class Patient
    {
        private $name;
        private $birthdate;
        private $doctor_id;
        private $enroll_date;
        private $id;


        function __construct($name, $birthdate, $doctor_id, $enroll_date = null, $id = null)
        {
            $this->name = $name;
            $this->birthdate = $birthdate;
            $this->doctor_id = $doctor_id;
            $this->enroll_date = $enroll_date;
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
        function setBirthdate($new_birthdate)
        {
            $this->birthdate = $new_birthdate;
        }
        function getBirthdate()
        {
            return $this->birthdate;
        }
        function setDoctorId($new_doctor_id)
        {
            $this->doctor_id = $new_doctor_id;
        }
        function getDoctorId()
        {
            return $this->doctor_id;
        }
        function setEnrollDate($new_enroll_date)
        {
            $this->enroll_date = $new_enroll_date;
        }
        function getEnrollDate()
        {
            return $this->enroll_date;
        }
        function setId($new_id)
        {
            $this->id = $new_id;
        }
        function getId()
        {
            return $this->id;
        }
        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO patients (name, birthdate, doctor_id, enroll_date) VALUES ('{$this->getName()}','{$this->getBirthdate()}', '{$this->getDoctorId()}', NOW())");
            if ($executed){
                $this->id = $GLOBALS['DB']->lastInsertId();
                return true;
            } else {
                return false;
            }
        }

        static function getAll()
        {
            $returned = $GLOBALS['DB']->query("SELECT * FROM patients;");
            $results = $returned->fetchAll(PDO::FETCH_OBJ);
            return $results;
        }

        function find($id)
        {
            $returned = $GLOBALS['DB']->prepare("SELECT * FROM patients WHERE id = :id;");
            $returned->bindParam(':id', $id, PDO::PARAM_STR);
            $returned->execute();
            $result = $returned->fetch(PDO::FETCH_ASSOC);
            if ($result['id'] == $id) {
              $found_patient = new Patient($result['name'], $result['birthdate'], $result['doctor_id'], $result['enroll_date']);
            }
            return $found_patient;
        }
        static function getPatients($doctor_id)
        {
            $returned = $GLOBALS['DB']->prepare("SELECT * FROM patients WHERE doctor_id = :id");
            $returned->bindParam(':id', $doctor_id, PDO::PARAM_STR);
            $returned->execute();
            $results = $returned->fetchAll(PDO::FETCH_OBJ);
            return $results;
        }

    }

?>
