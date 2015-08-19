<?php
    class Cuisine
    {
        private $type;
        private $id;


        function __construct($type, $id = null)
        {
            $this->type = $type;
            $this->id = $id;
        }

        function setCuisineType($new_type)
        {
            $this->type = (string) $new_type;
        }

        function getCuisineType()
        {
            return $this->type;
        }

        function getId()
        {
            return $this->id;
        }
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO cuisines (type) VALUES ('{$this->getCuisineType()}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }
        static function getAll()
        {
            $returned_cuisines = $GLOBALS['DB']->query("SELECT * FROM cuisines;");
            $cuisines = array();
            foreach($returned_cuisines as $cuisine) {
                $type = $cuisine['type'];
                $id = $cuisine['id'];
                $new_cuisine = new Cuisine($type, $id);
                array_push($cuisines, $new_cuisine);
            }
            return $cuisines;
        }
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM cuisines;");
        }
    }

 ?>
