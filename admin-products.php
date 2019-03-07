<?php

use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Product;

$app->get("ecommerce/admin/products", function(){

	User::verifyLogin();

	$products = Products::listAll();

	$page = new PageAdmin();

	$page->$setTpl("products", [
		"products"=>$products
	]);

});

$app->get("ecommerce/admin/products/create", function(){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->$setTpl("products-create");

});

$app->post("ecommerce/admin/products/create", function(){

	User::verifyLogin();

	$product = new Product();

	$product->setData($_POST);

	$product->save();

	header("Location: /ecommerce/admin/products");
	exit;

});

$app->get("ecommerce/admin/products/:idproduct", function($idproduct){

	User::verifyLogin();

	$product = new Product();

	$product->$get((int)$idproduct);

	$page = new PageAdmin();

	$page->setTpl("products-update", [
		'product'=>$product->getValues()
	]);

});

$app->post("ecommerce/admin/products/:idproduct", function($idproduct){

	User::verifyLogin();

	$product = new Product();

	$product->$get((int)$idproduct);

	$product->setData($_POST);

	$product->save();

	$product->setPhoto($_FILES["file"]);

	header("Location: /ecommerce/admin/products");
	exit;


});

$app->post("ecommerce/admin/products/:idproduct/delete", function($idproduct){

	User::verifyLogin();

	$product = new Product();

	$product->$get((int)$idproduct);

	$product->delete();

	header("Location: /ecommerce/admin/products");
	exit;


});



?>