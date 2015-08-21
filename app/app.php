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

    //Necessary for patch/delete routes:
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    //Homepage route:
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    //Lists cuisines on homepage:
    $app->post("/cuisines", function() use ($app) {
        $cuisine = new Cuisine($_POST['type']);
        $cuisine->save();
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    //View a particular cuisine's page and list of restaurants:
    $app->get("/cuisines/{id}", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()));
    });

    //Save a new restaurant:
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

    //View list of restaurants after save:
    $app->get("/restaurants", function() use ($app) {
        $cuisine = Cuisine::find($cuisine_id);
        return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'restaurants' => Restaurant::getAll()));
    });

    //Page for editing a cuisine:
    $app->get("/cuisines/{id}/edit", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        return $app['twig']->render('cuisine_edit.html.twig', array('cuisine' => $cuisine));
    });

    //Update a cuisine form:
    $app->patch("/cuisines/{id}", function($id) use ($app) {
        $type = $_POST['type'];
        $cuisine = Cuisine::find($id);
        $cuisine->update($type);
        return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()));
    });

    //Edit a restaurant page:
    $app->get("/restaurants/{id}/edit", function($id) use ($app) {
        $restaurant = Restaurant::find($id);
        $cuisine = Cuisine::find($restaurant->getCuisineId());
        return $app['twig']->render('restaurant_edit.html.twig', array('restaurant' => $restaurant, 'cuisine' => $cuisine));
    });

    //Show cuisine page with update restaurant:
    $app->patch("/restaurants/{id}", function($id) use ($app) {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $price = $_POST['price'];
        $restaurant = Restaurant::find($id);
        $restaurant->update($name, $phone, $price);
        $cuisine = Cuisine::find($restaurant->getCuisineId());
        return $app['twig']->render('cuisine.html.twig', array('restaurant' => $restaurant, 'cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()));
    });

    //Clear all items in database (cuisines AND restaurants):
    $app->post("/delete_cuisines", function() use ($app) {
        Restaurant::deleteAll();
        Cuisine::deleteAll();
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    return $app;

 ?>
