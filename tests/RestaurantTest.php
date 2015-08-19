<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Cuisine.php";
    require_once "src/Restaurant.php";

    $server = 'mysql:host=localhost;dbname=restaurants_by_cuisine_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class RestaurantTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Cuisine::deleteAll();
            Restaurant::deleteAll();
        }

        function test_getId()
        {
            //Arrange
            $type = "french";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $name = "Petit Provence";
            $phone = "555-555-5555";
            $price = "$$";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($id, $name, $phone, $price, $cuisine_id);
            $test_restaurant->save();

            //Act
            $result = $test_restaurant->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }



        // function test_getRestaurant()
        // {
        //     //Arrange
        //     $id = null;
        //     $name = 'petit provence';
        //     $phone = '555-555-5555';
        //     $price = '$$';
        //     $cuisine_id = 1;
        //     $test_restaurant = new Restaurant($id, $name, $phone, $price, $cuisine_id);
        //
        //
        //     //Act
        //     $result = $test_restaurant->getRestaurant();
        //
        //     //Assert
        //
        //     $this->assertEquals($test_restaurant, $result);
        // }
    }

 ?>
