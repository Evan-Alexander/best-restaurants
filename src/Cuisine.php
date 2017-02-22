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

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO cuisine (cuisinetype) VALUES ('{$this->getCuisineType()}')");
            $this->id= $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_cuisines = $GLOBALS['DB']->query("SELECT * FROM cuisine;");
            $cuisines = array();
            foreach ($returned_cuisines as $cuisine) {
                $cuisine_type = $cuisine['cuisinetype'];
                $id = $cuisine['id'];
                $new_cuisine = new Cuisine($cuisine_type, $id);
                array_push($cuisines, $new_cuisine);
            }
            return $cuisines;
        }
    }
?>
