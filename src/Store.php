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


    }
 ?>
