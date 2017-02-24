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

        function test_update()
        {
            $cuisine_name = "Ethiopian";
            $test_Cuisine = new Cuisine($cuisine_name);
            $test_Cuisine->save();
            $replacement_name = "Turkish";

            $test_Cuisine->update($replacement_name);
            $result = $test_Cuisine->getCuisineType();

            $this->assertEquals($replacement_name, $result);
        }

        function test_deletebyID()
        {
            $cuisine_name = "Haute";
            $test_Cuisine= new Cuisine($cuisine_name);
            $test_Cuisine->save();

            $restaurant_name = "Spits In Your Food";
            $cuisine_id = $test_Cuisine->getId();
            $price = 4;
            $new_restaurant = new Restaurant($restaurant_name, $cuisine_id, $price);
            $new_restaurant->save();

            $restaurant_name2 = "Snotty Waiter";
            $cuisine_id2 = 4036;
            $price2 = 5;
            $new_restaurant2 = new Restaurant($restaurant_name2, $cuisine_id2, $price2);
            $new_restaurant2->save();

            $test_Cuisine->delete();
            $result = Restaurant::getAll();

            $this->assertEquals(array($new_restaurant2), $result);
        }

        function test_sanitize()
        {
            $cuisine_name = "'Chuck's & Bites'";
            $test_Cuisine= new Cuisine($cuisine_name);
            $test_Cuisine->sanitize();
            $test_Cuisine->save();

            $result = $test_Cuisine->getCuisineType();

            $this->assertEquals("\'Chuck\'s &amp; Bites\'", $result);
        }

        function test_desanitize()

        {
            $cuisine_name = "\'Chuck\'s &amp; Bites\'";
            $test_Cuisine= new Cuisine($cuisine_name);
            $test_Cuisine->desanitize();
            $test_Cuisine->save();

            $result = $test_Cuisine->getCuisineType();

            $this->assertEquals("'Chuck's & Bites'", $result);
        }
    }


?>
