<?php
    class Restaurant
    {
        private $name;
        private $phone;
        private $price;
        private $cuisine_id;
        private $id;

        function __construct($name, $phone, $price, $cuisine_id, $id = null)
        {
            $this->name = $name;
            $this->phone = $phone;
            $this->price = $price;
            $this->cuisine_id = $cuisine_id;
            $this->id = $id;
        }

        function getId()
        {
            return $this->id;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function setPhone($new_phone)
        {
            $this->phone = (string) $new_phone;
        }

        function getPhone()
        {
            return $this->phone;
        }

        function setPrice($new_price)
        {
            $this->price = (string) $new_price;
        }

        function getPrice()
        {
            return $this->price;
        }

        function getCuisineId()
        {
            return $this->cuisine_id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO restaurants (name, phone, price, cuisine_id)
            VALUES (
                '{$this->getName()}',
                '{$this->getPhone()}',
                '{$this->getPrice()}',
                {$this->getCuisineId()}
            );");

            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants;");
            $restaurants = array();
            foreach($returned_restaurants as $restaurant) {
                $name = $restaurant['name'];
                $phone = $restaurant['phone'];
                $price = $restaurant['price'];
                $cuisine_id = $restaurant['cuisine_id'];
                $id = $restaurant['id'];
                $new_restaurant = new Restaurant($name, $phone, $price, $cuisine_id, $id);
                array_push($restaurants, $new_restaurant);
            }
            return $restaurants;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurants;");
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurants WHERE id = {$this->getId()};");
        }

        static function find($search_id)
        {
            $found_restaurant = null;
            $restaurants = Restaurant::getAll();
            foreach($restaurants as $restaurant) {
                $restaurant_id = $restaurant->getId();
                if($restaurant_id == $search_id) {
                    $found_restaurant = $restaurant;
                }
            }
            return $found_restaurant;
        }
    }

 ?>
