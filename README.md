# Shoe Stores

#### Epicodus PHP Week 4 Solo Project, 3/3/2017

#### By Jake Campa

## Description

Shoe Stores website to create many to many relationships between stores and brands of shoes

## Setup/Installation Requirements

* See https://secure.php.net/ for details on installing _PHP_.  Note: PHP is typically already installed on Macs.
* See https://getcomposer.org for details on installing _composer_.
* Clone repository
* Open MAMP- see https://www.mamp.info/en/downloads/ for details on installing _MAMP_
* Start MAMP server
* In MAMP click Preferences
* In the Web Server Tab set the document root to the web folder of the repo
* Run following in terminal /Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot
* Open localhost:8888/phpmyadmin in browser
* Go to import tab
* Install shoes.zip.sql to access database structure
* Install shoes_test.zip.sql to access database structure for phpunit tests
* From project root, run > composer install
* From web folder in project, Start PHP > php -S localhost:8000
* In web browser open localhost:8000
* You can also go to localhost:8888 if

#### Error with importing mySQL files
_After running "/Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot" use the following commands in terminal to create the database structure from scratch_
* CREATE DATABASE shoes;
* USE shoes;
* CREATE TABLE stores (id serial PRIMARY KEY, name VARCHAR(255));
* CREATE TABLE brands (id serial PRIMARY KEY, name VARCHAR(255));
* CREATE TABLE brands_stores (id serial PRIMARY KEY, brand_id BIGINT, store_id BIGINT);

To create the shoes_test Database go to localhost:8888 and click on shoes in the side menu. Click on the tab Operations near the top of the webpage. In "Copy database to" panel, change shoes to shoes_test in the text field and select structure only in the menu while keeping the default selections. Click go in the panel_

## Known Bugs
* No known bugs

## Specifications

| Behavior | Input | Output |      
|---| --- | --- |        
|Add Store| store_name = 'Foo Shoe Store'|store_name = 'Foo Shoe Store'|        
|Add Brand|brand_name = 'Bar'|brand_name = 'Bar'|        
|Assign Brand to Store|Foo shoe store's brands = 'Bar', 'Baz'|Foo shoe store's brands = 'Bar', 'Baz'|        
|Assign Store to Brand|Stores that sell 'Bar' = 'Foo Shoe Store', 'Corge Store'|Stores that sell 'Bar' = 'Foo Shoe Store', 'Corge Store'|
|Update Store | store_name = 'Foo Shoe Store' : new_store_name = 'Qux Shoe Store'|store_name = 'Qux Shoe Store'|        
|Update Brand |brand_name = 'Bar': new_brand_name = 'Quuz'|new_brand_name = 'Quuz'|
|Delete Store |store = 'Foo' | Store Deleted|
|Delete Brand |brand = 'Bar' | Brand Deleted|



## Support and contact details
no support

## Technologies Used
* PHP
* Composer
* MySQL
* Silex
* Twig
* HTML
* CSS
* Bootstrap
* Git

## Copyright (c)
* 2017 Jake Campa

## License
* MIT
