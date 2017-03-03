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
    	}


    }
 ?>
