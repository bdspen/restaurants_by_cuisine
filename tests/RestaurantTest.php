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

        function test_getCuisineId()
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
            $test_restaurant = new Restaurant($name, $phone, $price, $cuisine_id);
            $test_restaurant->save();

            //Act
            $result = $test_restaurant->getCuisineId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
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
            $test_restaurant = new Restaurant($name, $phone, $price, $cuisine_id, $id);
            $test_restaurant->save();


            //Act
            $result = Restaurant::getAll();



            //Assert
            $this->assertEquals($test_restaurant, $result[0]);
        }

        function test_getAll()
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
            $test_restaurant = new Restaurant($name, $phone, $price, $cuisine_id);
            $test_restaurant->save();


            $name2 = "Escargot";
            $phone2 = "666-666-6666";
            $price2 = "$$$";
            $test_restaurant2 = new Restaurant($name2, $phone2, $price2, $cuisine_id);
            $test_restaurant2->save();

            //Act
            $result = Restaurant::getAll();

            //Assert
            $this->assertEquals([$test_restaurant, $test_restaurant2], $result);
        }

        function test_find()
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
            $test_restaurant = new Restaurant($name, $phone, $price, $cuisine_id);
            $test_restaurant->save();


            $name2 = "Escargot";
            $phone2 = "666-666-6666";
            $price2 = "$$$";
            $test_restaurant2 = new Restaurant($name2, $phone2, $price2, $cuisine_id);
            $test_restaurant2->save();

            //Act
            $result = Restaurant::find($test_restaurant->getId());

            //Assert
            $this->assertEquals($test_restaurant, $result);
        }

        function test_deleteRestaurant()
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
            $test_restaurant->delete();

            //Assert
            $this->assertEquals([], Restaurant::getAll());
        }

        function test_deleteInCuisine()
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
            $test_restaurant = new Restaurant($name, $phone, $price, $cuisine_id);
            $test_restaurant->save();


            $name2 = "Escargot";
            $phone2 = "666-666-6666";
            $price2 = "$$$";
            $cuisine_id2 = $test_cuisine->getId();
            $test_restaurant2 = new Restaurant($name2, $phone2, $price2, $cuisine_id);
            $test_restaurant2->save();

            //Act
            $test_restaurant->deleteInCuisine();

            //Assert
            $this->assertEquals([], Restaurant::getAll());
        }

        function testUpdate()
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
            // $id = null;
            $test_restaurant = new Restaurant($name, $phone, $price, $cuisine_id);
            $test_restaurant->save();

            $new_name = "Escargot";
            $new_phone = "666-666-6666";
            $new_price = "$$$";
            // $cuisine_id = 1;
            // $new_id = null;
            $new_test_restaurant = new Restaurant($new_name, $new_phone, $new_price, $cuisine_id, $test_restaurant->getId());
            // $new_test_restaurant->save();
            // var_dump($new_test_restaurant);


            //Act
            $test_restaurant->update($new_name, $new_phone, $new_price);



            //Assert
            $this->assertEquals($test_restaurant, $new_test_restaurant);
        }

    }

 ?>
