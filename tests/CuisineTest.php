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
        protected function tearDown()
        {
            Cuisine::deleteAll();
            Restaurant::deleteAll();
        }

        function test_constructorAndGetters()
        {
            $cuisine_type = "Mexican";
            $id = null;

            $new_cuisine = new Cuisine($cuisine_type, $id);

            $result = $new_cuisine->getCuisineType();

            $this->assertEquals($cuisine_type, $result);
        }

        function test_saveAndGetAll()
        {
            // Arrange
            $name = "Sizzler";
            $test_Cuisine = new Cuisine($name);
            $test_Cuisine->save();

            $name2 = "Pho Oregon";
            $test_Cuisine2 = new Cuisine($name2);
            $test_Cuisine2->save();

            // Act
            $result = Cuisine::getAll();
            var_dump($result);


            // Assert
            $this->assertEquals([$test_Cuisine, $test_Cuisine2], $result);
        }

        function test_DeleteAll()
        {
            $name = "Some Food";
            $test_Cuisine = new Cuisine($name);

            $test_Cuisine->save();
            Cuisine::deleteAll();
            $result = Cuisine::getAll();

            $this->assertEquals([], $result);
        }

        function test_find()
        {
            $name = "chinese";
            $test_Cuisine = new Cuisine($name);

            $test_Cuisine->save();

            $result = Cuisine::find($test_Cuisine->getId());

            $this->assertEquals($test_Cuisine, $result);
        }


    }


?>
