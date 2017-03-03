<?php
date_default_timezone_set('America/Los_Angeles');

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../src/Store.php";
require_once __DIR__ . "/../src/Brand.php";

$app = new Silex\Application();

$app['debug'] = true;

$server = 'mysql:host=localhost:8889;dbname=shoe_store';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

use Symfony\Component\HttpFoundation\Request;
Request::enableHttpMethodParameterOverride();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
));
$app->get("/", function() use ($app) {
    return $app['twig']->render('index.html.twig');
});
$app->get("/view_stores", function() use ($app) {
    $stores = Store::getAll();
    return $app['twig']->render('stores.html.twig', array('stores' => $stores));
});
$app->get("/view_brands", function() use ($app) {
    $brands = Brand::getAll();
    return $app['twig']->render('brands.html.twig', array('brands' => $brands));
});
$app->get("/edit_store/{id}", function($id) use ($app) {
    $store = Store::find($id);
    $brands_not_carrying = $store->getBrandsNotCarrying;
    return $app['twig']->render('edit_store.html.twig', array('store' => $store, 'brands' => $brands_not_carrying));
});
$app->get("/edit_brand/{id}", function($id) use ($app) {
    $brand = Brand::find($id);
    return $app['twig']->render('edit_brand.html.twig', array('brand' => $brand));
});
$app->patch("/edit_store_name/{id}", function($id) use ($app) {
    $store = Store::find($id);
    $store->updateName($_POST['new_name']);
    return $app->redirect('/edit_store/' . $id);
});
$app->patch("/edit_brand_name/{id}", function($id) use ($app) {
    $brand = Brand::find($id);
    $brand->updateName($_POST['new_name']);
    return $app->redirect('/edit_brand/' . $id);
});
$app->delete("/delete_store/{id}", function($id) use ($app) {
    $store = Store::find($id);
    $store->delete();
    return $app->redirect('/view_stores');
});
$app->delete("/delete_brand/{id}", function($id) use ($app) {
    $brand = Brand::find($id);
    $brand->delete();
    return $app->redirect('/view_brands');
});
$app->post("/add_store", function() use ($app) {
    $store = new Store($_POST['name']);
    $store->save();
    return $app->redirect('/view_stores');
});
$app->post("/add_brand", function() use ($app) {
    $brand = new Brand($_POST['name']);
    $brand->save();
    return $app->redirect('/view_brands');
});
$app->post("/add_brand_to_store/{id}", function($id) use ($app) {
    $store = Store::find($id);
    $store->addBrand($_POST['brand']);
    return $app->redirect('/edit_store/' . $id);
});
return $app;
?>
