<?php

    class Store
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
    		$GLOBALS['DB']->exec("INSERT INTO stores (name) VALUES ('{$this->getName()}')");
    		$this->id = $GLOBALS['DB']->lastInsertId();
    	}
        static function getAll()
    	{
    		$returned_store = $GLOBALS['DB']->query("SELECT * FROM stores;");
    		$stores = array();
    		foreach($returned_store as $store)
    		{
    			$id = (int)$store['id'];
    			$store_name = $store['name'];
    			$new_store = new Store($store_name, $id);
    			array_push($stores, $new_store);
    		}
    		return $stores;
    	}
        static function deleteAll()
    	{
    		$GLOBALS['DB']->exec("DELETE FROM stores;");
            $GLOBALS['DB']->exec("DELETE FROM brands_stores;");

    	}
        function updateName($new_name)
    	{
    		$GLOBALS['DB']->exec("UPDATE stores SET name = '{$new_name}' WHERE id = {$this->getId() };");
    		$this->setName($new_name);
    	}

        function delete()
    	{
    		$GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId() };");
    		$GLOBALS['DB']->exec("DELETE FROM brands_stores WHERE store_id = {$this->getId() };");
    	}

        static function find($search_id)
    	{
    		$stores = Store::getAll();
    		foreach($stores as $store)
    		{
    			$store_id = $store->getId();
    			if ($store_id == $search_id)
    			{
    				return $store;
    			}
    		}
    		return null;
    	}
        function addBrand($brand_id)
        {
            $store_id = $this->getId();
            $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$brand_id}, {$store_id});");
        }
        function removeBrand($brand_id)
        {
            $store_id = $this->getId();
            $GLOBALS['DB']->exec("DELETE FROM brands_stores WHERE brand_id = {$brand_id} and store_id = {$store_id};");
        }

        function getBrands()
        {
            $returned_brands = $GLOBALS['DB']->query(
                "SELECT brands.*
                FROM stores
                JOIN brands_stores ON (brands_stores.store_id = stores.id)
                JOIN brands ON (brands.id = brands_stores.brand_id)
                WHERE stores.id = {$this->getId()};"
            );
            $brands = array();
            if ($returned_brands == null) {
                return null;
            }
            foreach ($returned_brands as $brand) {
                $id = $brand['id'];
                $name = $brand['name'];
                $new_brand = new Brand($name, $id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }
        function getBrandsNotCarrying()
        {
            $all_brands = Brand::getAll();
            $current_brands = $this->getBrands();
            $diff_array = [];
            foreach ($all_brands as $brand) {
                $counter = 0;
                foreach ($current_brands as $current_brand) {
                    if ($current_brand->getId() == $brand->getId()){
                        $counter = 1;
                    }
                }
                if ($counter == 0) {
                    array_push($diff_array, $brand);
                }
            }
            return $diff_array;
        }

    }
 ?>
