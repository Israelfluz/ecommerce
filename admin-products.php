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

$app->get("ecommerce/admin/products", function(){

	User::verifyLogin();

	$products = Products::listAll();

	$page = new PageAdmin();

	$page->$setTpl("products", [
		"products"=>$products
	]);
	
});

/admin/products/create

?>