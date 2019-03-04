<?php

use \Hcode\Page;
use \Hcode\Model\Product;
use \Hcode\Model\Category;

$app->get('/', function() {

	$products = Product::listAll();
    
	$page = new Page();   

	$page->setTpl("index", [
		'products'=>Product::checklist($products)
	]);

});

$app->get("/ecommerce/categories/:idcategory", function($idcategory){

	$category = new Category();

	$category->get((int)$idcategory);

	$page = new Page();

	$page->setTpl("category", [
		'category'=>$category->getValues(),
		'products'=>Product::checList($category->getProducts())
	]);

});

?>