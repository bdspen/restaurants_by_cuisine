<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Cuisine.php";
    // require_once "src/Restaurant.php";

    $server = 'mysql:host=localhost;dbname=restaurants_by_cuisine_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CuisineTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Cuisine::deleteAll();
            Restaurant::deleteAll();
        }

        function test_getCuisineType()
        {
            //Arrange
            $type = "french";
            $test_cuisine = new Cuisine($type);


            //Act
            $result = $test_cuisine->getCuisineType();

            //Assert

            $this->assertEquals($type, $result);
        }

        function test_getId()
        {
            //Arrange
            $type = "french";
            $id = 1;
            $test_cuisine = new Cuisine($type, $id);

            //Act
            $result = $test_cuisine->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //Arrange
            $type = "french";
            $test_cuisine = new Cuisine($type);
            $test_cuisine->save();

            //Act
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals($test_cuisine, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $type = "french";
            $type2 = "mexican";
            $test_cuisine = new Cuisine($type);
            $test_cuisine->save();
            $test_cuisine2 = new Cuisine($type);
            $test_cuisine2 ->save();

            //Act
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals([$test_cuisine, $test_cuisine2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $type = "french";
            $type2 = "mexican";
            $test_cuisine = new Cuisine($type);
            $test_cuisine->save();
            $test_cuisine2 = new Cuisine($type);
            $test_cuisine2->save();

            //Act
            Cuisine::deleteAll();
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $type = "french";
            $type2 = "mexican";
            $test_cuisine = new Cuisine($type);
            $test_cuisine->save();
            $test_cuisine2 = new Cuisine($type);
            $test_cuisine2->save();

            //Act
            $result = Cuisine::find($test_cuisine->getId());

            //Assert
            $this->assertEquals($test_cuisine, $result);
        }

        function test_search()
        {
            //Arrange
            $type = "french";
            $test_cuisine = new Cuisine($type);
            $test_cuisine->save();

            //Act
            $result = Cuisine::search($test_cuisine->getCuisineType());

            //Assert
            $this->assertEquals($test_cuisine, $result);
        }

        function test_GetRestaurants()
        {
            //Arrange
            $type = "french";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $test_type_id = $test_cuisine->getId();

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
            $result = $test_cuisine->getRestaurants();

            //Assert
            $this->assertEquals([$test_restaurant, $test_restaurant2], $result);
        }

        function test_deleteCuisine()
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
            $test_cuisine->delete();

            //Assert
            $this->assertEquals([], Cuisine::getAll());
        }

        function testUpdate()
        {
            //Arrange
            $type = "french";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $new_type = "mexican";

            //Act
            $test_cuisine->update($new_type);

            //Assert
            $this->assertEquals("mexican", $test_cuisine->getCuisineType());
        }
    }

?>
