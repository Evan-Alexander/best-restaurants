<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Restaurant.php";
    require_once __DIR__."/../src/Cuisine.php";


    use Symfony\Component\Debug\Debug;
    Debug::enable();

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app = new Silex\Application();
    $app['debug']=true;


    $server = 'mysql:host=localhost:8889;dbname=best_restaurants';
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
        $cuisine = new Cuisine($_POST['cuisine_name']);
        $cuisine->save();
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->get("/cuisines", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->get("/cuisines/{id}", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        $restaurants = Restaurant::searchByCuisine($id);
        var_dump($restaurants);
        return $app['twig']->render('cuisine.html.twig', array('cuisines' => $cuisine, 'restaurants' => $restaurants));
    });

    $app->post("/restaurant", function() use ($app) {
        $new_restaurant = new Restaurant ($_POST['restaurant_name'], $_POST['cuisine_id'], $_POST['price']);
        $new_restaurant->save();
        $cuisines = Cuisine::find($_POST['cuisine_id']);
        $restaurants = Restaurant::searchByCuisine($_POST['cuisine_id']);

        return $app['twig']->render('cuisine.html.twig', array('cuisines' => $cuisines, 'restaurants' => $restaurants));
    });

    $app->get("/restaurant-edit/{id}", function($id) use ($app) {
        $edit_restaurant = Restaurant::find($id);
        $current_price = $edit_restaurant->getPrice();
        return $app['twig']->render('restaurant-editor.html.twig', array('restaurant' => $edit_restaurant, 'cuisines' => Cuisine::getAll()));
    });

    $app->patch("/display-update", function() use ($app) {
        $current_restaurant = Restaurant::find($_POST['id']);
        $current_restaurant->update($_POST['new-name'], $_POST['price-update'], $_POST['cuisine_update']);
        $cuisine = Cuisine::find($_POST['cuisine_update']);
        $restaurants = Restaurant::searchByCuisine(['cuisine_update']);
        return $app['twig']->render('cuisine.html.twig', array('cuisines' => $cuisine, 'restaurants' => $restaurants));
    });

    $app->delete("/delete_restaurant/{id}", function($id) use ($app) {
        $restaurant = Restaurant::find($id);
        $restaurant->deleteRestaurant();

        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    return $app;

?>
