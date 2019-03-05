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

	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	$category = new Category();

	$category->get((int)$idcategory);

	$pagination = $category->getProductsPage($page);

	$page = [];

	for ($i=1; $i <= $pagination['pages']; $i++) {
		array_push($pages, [
			'link'=>'/ecommerce/categories/' .$category->getidcategory().'pages='.$i,
			'pages'=>$i
		]);

	}

	$page = new Page();

	$page->setTpl("category", [
		'category'=>$category->getValues(),
		'products'=>$pagination["data"],
		'pages'=>$pages
	]);

});

?>