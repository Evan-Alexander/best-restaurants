<?php
    Class Restaurant
    {
        private $restaurant_name;
        private $cuisine_id;
        private $price;
        private $id;

        function __construct($restaurant_name, $cuisine_id, $price, $id = null)
        {
            $this->restaurant_name = $restaurant_name;
            $this->cuisine_id = $cuisine_id;
            $this->price = $price;
            $this->id = $id;
        }

        function setRestaurantName($new_name)
        {
            $this->restaurant_name = $new_name;
        }

        function getRestaurantName()
        {
            return $this->restaurant_name;
        }

        function getCuisineId()
        {
            return $this->cuisine_id;
        }

        function setCuisine_Id($new_cuisine_id)
        {
            $this->cuisine_id = $new_cuisine_id;
        }

        function setPrice($new_price)
        {
            $this->price = $new_price;
        }

        function getPrice()
        {
            return $this->price;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $this->sanitize();
            $GLOBALS['DB']->exec("INSERT INTO restaurant (restaurant_name, cuisine_id, price) VALUES ('{$this->getRestaurantName()}', {$this->getCuisineId()}, {$this->getPrice()})");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function GetAll()
        {
            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurant;");
            $restaurants = array();
            foreach ($returned_restaurants as $restaurant){
                $restaurant_name = $restaurant['restaurant_name'];
                $cuisine_id = $restaurant['cuisine_id'];
                $price = $restaurant['price'];
                $id = $restaurant['id'];
                $new_restaurant = new Restaurant($restaurant_name, $cuisine_id, $price, $id);
                $new_restaurant->desanitize();
                array_push($restaurants, $new_restaurant);
            }
            return $restaurants;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurant;");
        }

        static function find($search_id)
        {
            $found_restaurant = null;
            $restaurants = Restaurant::getAll();
            foreach($restaurants as $restaurant) {
                $restaurant_id = $restaurant->getId();
                if ($restaurant_id == $search_id) {
                    $found_restaurant = $restaurant;
                }
            }
            return $found_restaurant;
        }

        static function searchByCuisine($cuisine_id)
        {
            $found_restaurants = array();
            $restaurants = Restaurant::getAll();
            foreach ($restaurants as $restaurant) {
                $found_cuisine_id = $restaurant->getCuisineId();
                if ($found_cuisine_id == $cuisine_id) {
                    array_push($found_restaurants, $restaurant);
                }
            }
            return $found_restaurants;
        }

        function update($new_name, $new_price, $new_cuisine_id)
        {
            $this->setRestaurantName($new_name);
            $this->setPrice($new_price);
            $this->setCuisine_Id($new_cuisine_id);
            $this->sanitize();
            $GLOBALS['DB']->exec("UPDATE restaurant SET restaurant_name = '{$this->restaurant_name}', price = '{$this->price}', cuisine_id = '{$this->cuisine_id}' WHERE id = {$this->getId()};");
        }

        function deleteRestaurant()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurant WHERE id = {$this->getId()}");
        }

        function sanitize()
        {
            $this->restaurant_name = htmlspecialchars(addslashes(trim($this->restaurant_name)));
        }

        function desanitize()
        {
            $this->restaurant_name = htmlspecialchars_decode(stripslashes($this->restaurant_name));
        }
    }
?>
