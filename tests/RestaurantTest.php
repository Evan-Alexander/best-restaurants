<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Cuisine.php";
    require_once "src/Restaurant.php";

    $server = 'mysql:host=localhost:8889;dbname=best_restaurants_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class RestaurantTest extends PHPUnit_Framework_TestCase
    {
        function test_constructorAndGetters()
        {
            $restaurant_name = "Santeria";
            $id = null;
            $cuisine_id = 1;
            $price = 2;

            $new_restaurant = new Restaurant($restaurant_name, $cuisine_id, $price, $id);

            $result_restaurant_name = $new_restaurant->getRestaurantName();
            $result_cuisine_id = $new_restaurant->getCuisineId();
            $result_price = $new_restaurant->getPrice();
            $resultarray = array();
            array_push($resultarray, $result_restaurant_name, $result_cuisine_id, $result_price);

            $this->assertEquals($resultarray, [$restaurant_name, $cuisine_id, $price]);

        }
    }

?>
