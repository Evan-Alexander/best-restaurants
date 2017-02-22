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

    class CuisineTest extends PHPUnit_Framework_TestCase
    {
        function test_constructorAndGetters()
        {
            $cuisine_type = "Mexican";
            $id = null;

            $new_cuisine = new Cuisine($cuisine_type, $id);

            $result = $new_cuisine->getCuisineType();

            $this->assertEquals($cuisine_type, $result);
        }
    }


?>
