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

        function setCuisineType($new_name)
        {
            $this->cuisine_type = $new_name;
        }

        function getId()
        {
            return $this->id;
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

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM cuisine;");
        }

        static function find($search_id)
        {
            $found_cuisine = null;
            $cuisines = Cuisine::getAll();
            foreach ($cuisines as $cuisine) {
                $cuisine_id = $cuisine->getId();
                if ($cuisine_id == $search_id) {
                    $found_cuisine = $cuisine;
                }
            }
            return $found_cuisine;
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE cuisine SET cuisinetype = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setCuisineType($new_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM cuisine WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM restaurant WHERE cuisine_id = {$this->getId()};");
        }

        function sanitize()
        {
            $this->cuisine_type = htmlspecialchars(addslashes(trim($this->cuisine_type)));
        }

        function desanitize()
        {
            $this->cuisine_type = htmlspecialchars_decode(stripslashes($this->cuisine_type));
        }
    }
?>
