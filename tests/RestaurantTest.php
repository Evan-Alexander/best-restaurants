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

        function test_getAllandSave()
        {
            $restaurant_name1 = "Pies R Us";
            $cuisine_id1 = 1;
            $price1 = 2;
            $restaurant1 = new Restaurant($restaurant_name1, $cuisine_id1, $price1);
            $restaurant1->save();
            $restaurant_name2 = "Cake for All";
            $cuisine_id2 = 3;
            $price2 = 4;
            $restaurant2 = new Restaurant($restaurant_name2, $cuisine_id2, $price2);
            $restaurant2->save();

            $result = Restaurant::getAll();

            $this->assertEquals([$restaurant1, $restaurant2], $result);
        }
    }

?>
