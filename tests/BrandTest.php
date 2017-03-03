<?php

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Brand.php";

$server = 'mysql:host=localhost:8889;dbname=shoe_store_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

class brandTest extends PHPUnit_Framework_TestCase
{
    protected function teardown()
    {
        Brand::deleteAll();
    }
    function test_getName()
    {
        $name = 'Foo brand';
        $test_brand = new Brand($name);

        $result = $test_brand->getName();

        $this->assertEquals($name, $result);
    }
    function test_setName()
    {
        $name = 'Foo brand';
        $test_brand = new Brand($name);
        $new_name = 'Quuz brand';
        $test_brand->setName($new_name);

        $result = $test_brand->getName();

        $this->assertEquals($new_name, $result);
    }
    function test_getId()
    {
        $name = 'Foo brand';
        $id = 1;
        $test_brand = new Brand($name, 1);

        $result = $test_brand->getId();

        $this->assertEquals($id, $result);
    }
    function test_save()
    {
        $name = 'Foo brand';
        $test_brand = new Brand($name);

        $test_brand->save();
        $result = Brand::getAll();

        $this->assertEquals([$test_brand], $result);
    }
    function test_getAll()
    {
        $name = 'Foo brand';
        $test_brand = new Brand($name);
        $name2 = 'Quuz brand';
        $test_brand2 = new Brand($name2);

        $test_brand->save();
        $test_brand2->save();

        $result = Brand::getAll();

        $this->assertEquals([$test_brand, $test_brand2], $result);
    }
    function test_deleteAll()
    {
        $name = 'Foo brand';
        $test_brand = new Brand($name);

        $test_brand->save();
        Brand::deleteAll();

        $result = Brand::getAll();

        $this->assertEquals([], $result);
    }

    function test_find()
    {
        $name = 'Foo brand';
        $test_brand = new Brand($name);
        $name2 = 'Quuz brand';
        $test_brand2 = new Brand($name2);

        $test_brand->save();
        $test_brand2->save();

        $result = Brand::find($test_brand->getId());

        $this->assertEquals($test_brand, $result);

    }
    function test_updateName()
    {
        $name = 'Foo brand';
        $test_brand = new Brand($name);
        $new_name = 'Quuz brand';

        $test_brand->save();
        $test_brand->updateName($new_name);

        $result = $test_brand->getName();

        $this->assertEquals($new_name, $result);
    }
    function test_deleteOne()
    {
        $name = 'Foo brand';
        $test_brand = new Brand($name);
        $name2 = 'Quuz brand';
        $test_brand2 = new Brand($name2);

        $test_brand->save();
        $test_brand2->save();
        $test_brand->delete();

        $result = Brand::find($test_brand->getId());

        $this->assertEquals(null, $result);
    }


}



 ?>
