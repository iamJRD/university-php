<?php
    require_once __DIR__ .'/../vendor/autoload.php';
    require_once __DIR__.'/../src/Student.php';
    require_once __DIR__.'/../src/Course.php';

    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=university';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));
// INDEX PAGE
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    $app->get("/students", function() use ($app) {
        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    $app->get("/courses", function() use ($app) {
        return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });

    $app->post("/delete_all", function() use ($app) {
        Course::deleteAll();
        Student::deleteAll();
        return $app['twig']->render('index.html.twig');
    });
// STUDENT PAGE
    $app->post("/add_student", function() use ($app) {
        $name = $_POST['name'];
        $enrollment = $_POST['enrollment'];
        $id = null;
        $new_student = new Student($name, $enrollment, $id);
        $new_student->save();
        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    $app->post("/delete_all_students", function() use ($app) {
        Student::deleteAll();
        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    return $app;
?>
