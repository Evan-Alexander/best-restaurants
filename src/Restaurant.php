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

        function getRestaurantName()
        {
            return $this->restaurant_name;
        }

        function getCuisineId()
        {
            return $this->cuisine_id;
        }

        function getPrice()
        {
            return $this->price;
        }

        function getId()
        {
            return $this->id;
        }



    }
?>
