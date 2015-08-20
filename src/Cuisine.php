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

        static function find($search_id)
        {
            $found_cuisine = null;
            $cuisines = Cuisine::getAll();
            foreach($cuisines as $cuisine) {
                $cuisine_id = $cuisine->getId();
                if ($cuisine_id == $search_id) {
                    $found_cuisine = $cuisine;
                }
            }
            return $found_cuisine;
        }
        static function search($search_type)
        {
            $found_cuisine = null;
            $cuisines = Cuisine::getAll();
            foreach($cuisines as $cuisine) {
                $cuisine_type = $cuisine->getCuisineType();
                if ($cuisine_type == $search_type) {
                    $found_cuisine_type = $cuisine;
                }
            }
            return $found_cuisine_type;
        }

        function getRestaurants()
        {
            $restaurants = array();
            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants WHERE cuisine_id = {$this->getId()};");
            foreach($returned_restaurants as $restaurant) {
                $name = $restaurant['name'];
                $id = $restaurant['id'];
                $phone = $restaurant['phone'];
                $price = $restaurant['price'];
                $cuisine_id = $restaurant['cuisine_id'];
                $new_restaurant = new Restaurant($name, $phone, $price, $cuisine_id, $id);
                array_push($restaurants, $new_restaurant);
            }
            return $restaurants;
        }

    }

 ?>
