<?php


    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Restaurant.php";
    require_once __DIR__."/../src/Cuisine.php";

    $app = new Silex\Application();
    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=restaurants_by_cuisine';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->post("/cuisines", function() use ($app) {
        $cuisine = new Cuisine($_POST['type']);
        $cuisine->save();
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->get("/cuisines/{id}", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()));
    });

    $app->post("/restaurants", function() use ($app) {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $price = $_POST['price'];
        $cuisine_id = $_POST['cuisine_id'];
        $restaurant = new Restaurant($name, $phone, $price, $cuisine_id);
        $restaurant->save();
        $cuisine = Cuisine::find($cuisine_id);
        return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()));
    });

    $app->get("/restaurants", function() use ($app) {
        $cuisine = Cuisine::find($cuisine_id);
        return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'restaurants' => Restaurant::getAll()));
    });

    $app->post("/delete_restaurants", function() use ($app) {
        Restaurant::deleteAll();
        $cuisine = Cuisine::find($_POST['cuisine_id']);
        return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'cuisines' => $cuisine->getRestaurants()));
    });

    $app->post("/delete_cuisines", function() use ($app) {
        Restaurant::deleteAll();
        Cuisine::deleteAll();
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll()));
    });



    return $app;

 ?>
