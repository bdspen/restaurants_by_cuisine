<?php
    class Restaurant
    {
        private $name;
        private $phone;
        private $price;
        private $cuisine_id;
        private $id;

        function __construct($id = null, $name, $phone, $price, $cuisine_id)
        {
            $this->id = $id;
            $this->name = $name;
            $this->phone = $phone;
            $this->cuisine_id = $cuisine_id;
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
            $GLOBALS['DB']->exec("INSERT INTO tasks (id, name, phone, price, cuisine_id)
            VALUES ({$this->getId()},
            '{$this->getName()}',
            '{$this->getPhone()}',
            '{$this->getPrice()}',
            {$this->getCuisineId()});");

            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurants;");
        }
    }

 ?>
