<?php

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Store.php";

// $server = 'mysql:host=localhost:8889;dbname=shoe_store_test';
// $username = 'root';
// $password = 'root';
// $DB = new PDO($server, $username, $password);

class StoreTest extends PHPUnit_Framework_TestCase
{
    function test_getName()
    {
        $name = 'Foo Store';
        $test_store = new Store($name);

        $result = $test_store->getName();

        $this->assertEquals($name, $result);
    }
    function test_setName()
    {
        $name = 'Foo Store';
        $test_store = new Store($name);
        $new_name = 'Quuz Store';
        $test_store->setName($new_name);

        $result = $test_store->getName();

        $this->assertEquals($new_name, $result);
    }
    function test_getId()
    {
        $name = 'Foo Store';
        $id = 1;
        $test_store = new Store($name, 1);

        $result = $test_store->getId();

        $this->assertEquals($id, $result);
    }
}



 ?>
