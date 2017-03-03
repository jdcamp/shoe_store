<?php

class Brand
{
    private $name;
    private $id;

    function __construct($name, $id = null)
    {
        $this->name = $name;
        $this->id = $id;
    }
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getId()
    {
        return $this->id;
    }
    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO brands (name) VALUES ('{$this->getName()}')");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }
    static function getAll()
    {
        $returned_brand = $GLOBALS['DB']->query("SELECT * FROM brands;");
        $brands = array();
        foreach($returned_brand as $brand)
        {
            $id = (int)$brand['id'];
            $brand_name = $brand['name'];
            $new_brand = new Brand($brand_name, $id);
            array_push($brands, $new_brand);
        }
        return $brands;
    }
    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM brands;");
        $GLOBALS['DB']->exec("DELETE FROM brands_stores;");
    }
    function updateName($new_name)
    {
        $GLOBALS['DB']->exec("UPDATE brands SET name = '{$new_name}' WHERE id = {$this->getId() };");
        $this->setName($new_name);
    }

    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM brands WHERE id = {$this->getId() };");
        $GLOBALS['DB']->exec("DELETE FROM brands_stores WHERE brand_id = {$this->getId() };");
    }

    static function find($search_id)
    {
        $brands = Brand::getAll();
        foreach($brands as $brand)
        {
            $brand_id = $brand->getId();
            if ($brand_id == $search_id)
            {
                return $brand;
            }
        }
        return null;
    }
    function addStore($store_id)
    {
        $brand_id = $this->getId();
        $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$brand_id}, {$store_id});");
    }

    function removeStore($store_id)
    {
        $brand_id = $this->getId();
        $GLOBALS['DB']->exec("DELETE FROM brands_stores WHERE brand_id = {$brand_id} and store_id = {$store_id};");
    }

    function getStores()
    {
        $returned_stores = $GLOBALS['DB']->query(
            "SELECT stores.*
            FROM brands
            JOIN brands_stores ON (brands_stores.brand_id = brands.id)
            JOIN stores ON (stores.id = brands_stores.store_id)
            WHERE brands.id = {$this->getId()};"
        );
        $stores = array();
        if ($returned_stores == null) {
            return null;
        }
        foreach ($returned_stores as $store) {
            $id = $store['id'];
            $name = $store['name'];
            $new_store = new Store($name, $id);
            array_push($stores, $new_store);
        }
        return $stores;
    }
    function getStoresNotCarryingBrand()
    {
        $all_stores = Store::getAll();
        $current_stores = $this->getStores();
        $diff_array = [];
        foreach ($all_stores as $store) {
            $counter = 0;
            foreach ($current_stores as $current_store) {
                if ($current_store->getId() == $store->getId()){
                    $counter = 1;
                }
            }
            if ($counter == 0) {
                array_push($diff_array, $store);
            }
        }
        return $diff_array;
    }


}



 ?>
