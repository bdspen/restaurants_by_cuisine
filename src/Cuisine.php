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
    }

 ?>
