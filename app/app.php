<?php
  date_default_timezone_set('America/Los_Angeles');
  require_once __DIR__."/../vendor/autoload.php";
  require_once __DIR__."/../src/Doctor.php";
  require_once __DIR__."/../src/Patient.php";

  use Symfony\Component\Debug\Debug;
  Debug::enable();

  $app = new Silex\Application();

  $app['debug'] = true;

  $server = 'mysql:host=localhost:8889;dbname=doctors_office';
  $username = 'root';
  $password = 'root';

  $DB = new PDO($server,$username,$password);

  $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
  ));

  $app -> get("/", function () use ($app) {
    $results = Doctor::getAll();
    return $app['twig']->render('index.html.twig', array ('results'=>$results));
  });

  $app -> post("/adddoctor", function () use ($app) {
    $new_doctor = new Doctor($_POST['doctorname'],$_POST['doctorspecialty']);
    $new_doctor->save();
    $results = Doctor::getAll();
    return $app['twig']->render('index.html.twig', array ('results'=>$results));
  });

  $app->get("/doctors/{id}", function($id) use ($app) {
    $result = Doctor::find($id);
    return $app['twig']->render('doctor.html.twig', array ('result'=>$result));
  });

  $app->get("/addpatient", function() use ($app) {
    $patient = new Patient($_GET['patientname'], $_GET['patientbirthdate'], $_GET['doctor_id']);
    $doctor = Doctor::find($_GET['doctor_id']);
    $patient->save();
    $patients = Patient::getPatients($_GET['doctor_id']);
    return $app['twig']->render('patients.html.twig', array ('patients'=>$patients, 'doctor'=>$doctor));
  });

  $app->get("/patient/{id}", function($id) use ($app) {
    $patient = Patient::find($id);
    return $app['twig']->render('patient.html.twig', array ('patient'=>$patient, 'id'=>$id));
  });
  return $app;
?>
