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
    }
    function updateName($new_name)
    {
        $GLOBALS['DB']->exec("UPDATE brands SET name = '{$new_name}' WHERE id = {$this->getId() };");
        $this->setName($new_name);
    }

    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM brands WHERE id = {$this->getId() };");
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


}



 ?>
