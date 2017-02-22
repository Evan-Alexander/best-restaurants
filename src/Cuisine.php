<?php
    Class Cuisine
    {
        private $id;
        private $cuisine_type;

        function __construct($cuisine_type, $id = null)
        {
            $this->cuisine_type = $cuisine_type;
            $this->id = $id;
        }

        function getCuisineType()
        {
            return $this->cuisine_type;
        }
    }
?>
