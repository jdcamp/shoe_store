<?php

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Store.php";
require_once "src/Brand.php";

$server = 'mysql:host=localhost:8889;dbname=shoe_store_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

class StoreTest extends PHPUnit_Framework_TestCase
{
    protected function teardown()
    {
        Store::deleteAll();
        Brand::deleteAll();
        $GLOBALS['DB']->exec("DELETE FROM brands_stores");
    }
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
    function test_save()
    {
        $name = 'Foo Store';
        $test_store = new Store($name);

        $test_store->save();
        $result = Store::getAll();

        $this->assertEquals([$test_store], $result);
    }
    function test_getAll()
    {
        $name = 'Foo Store';
        $test_store = new Store($name);
        $name2 = 'Quuz Store';
        $test_store2 = new Store($name2);

        $test_store->save();
        $test_store2->save();

        $result = Store::getAll();

        $this->assertEquals([$test_store, $test_store2], $result);
    }
    function test_deleteAll()
    {
        $name = 'Foo Store';
        $test_store = new Store($name);

        $test_store->save();
        Store::deleteAll();

        $result = Store::getAll();

        $this->assertEquals([], $result);
    }

    function test_find()
    {
        $name = 'Foo Store';
        $test_store = new Store($name);
        $name2 = 'Quuz Store';
        $test_store2 = new Store($name2);

        $test_store->save();
        $test_store2->save();

        $result = Store::find($test_store->getId());

        $this->assertEquals($test_store, $result);

    }
    function test_updateName()
    {
        $name = 'Foo Store';
        $test_store = new Store($name);
        $new_name = 'Quuz Store';

        $test_store->save();
        $test_store->updateName($new_name);

        $result = $test_store->getName();

        $this->assertEquals($new_name, $result);
    }
    function test_deleteOne()
    {
        $name = 'Foo Store';
        $test_store = new Store($name);
        $name2 = 'Quuz Store';
        $test_store2 = new Store($name2);

        $test_store->save();
        $test_store2->save();
        $test_store->delete();

        $result = Store::find($test_store->getId());

        $this->assertEquals(null, $result);
    }
    function test_addBrand_getBrands()
    {
        $name = 'Foo Store';
        $test_store = new Store($name);

        $name2 = 'Quuz';
        $test_brand = new Brand($name2);
        $name3 = 'Qux';
        $test_brand2 = new Brand($name3);

        $test_store->save();
        $test_brand->save();
        $test_brand2->save();
        $test_store->addBrand($test_brand->getId());
        $test_store->addBrand($test_brand2->getId());

        $result = $test_store->getBrands();


        $this->assertEquals([$test_brand,$test_brand2], $result);
    }


}



 ?>
