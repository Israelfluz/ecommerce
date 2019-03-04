<?php

use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Category;
use \Hcode\Model\Product; 

$app->get("/ecommerce/views/admin/categories", function(){

	User::verifylogin();

	$categories - Category::listAll();

	$page = new PageAdmin();
	 
	$page->setTpl("categories",[
		'categories'=>$categories

	]);

});

$app->get("/ecommerce/views/admin/categories/create", function(){

	User::verifylogin();

	$page = new PageAdmin();
	 
	$page->setTpl("categories-create");

});

$app->post("/ecommerce/views/admin/categories/create", function(){

	User::verifylogin();

	$category = new Category();

	$category->setData($_POST);

	$category->save();

	header('Location: /ecommerce/views/admin/categories');
	exit;

});

$app->get("/ecommerce/views/admin/categories/:idcategory/delete", function($idcategory){

	User::verifylogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$category->delete();

	header('Location: /ecommerce/views/admin/categories');
	exit;

});

$app->get("/ecommerce/views/admin/categories/:idcategory/delete", function($idcategory){

	User::verifylogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$page = new PageAdmin();
	 
	$page->setTpl("categories-update", [
		'category'=>$category->getValues()
	]);

}); 


$app->post("/ecommerce/views/admin/categories/:idcategory/delete", function($idcategory){

	User::verifylogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$category->setData($_POST);

	$category->save();

	header('Location: /ecommerce/views/admin/categories');
	exit;

}); 

$app->get("/ecommerce/views/admin/categories/:idcategory/products", function($idcategory){

	User::verifylogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$page = new PageAdmin();

	$page->setTpl("categories-products", [
		'category'=>$category->getValues(),
		'productsRelated'=>$category->getProducts(),
		'productsNotRelated'=>$category->getProducts(false)
	]);

}); 

$app->get("/ecommerce/views/admin/categories/:idcategory/products/:idproduct/add", function($idcategory, $idproduct){

	User::verifylogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$product-> new Product();

	$product->get((int)$idproduct);

	$category->addProduct($product);

	header("Location: /ecommerce/views/admin/categories/".$idcategory."/products");
	exit; 

}); 

$app->get("/ecommerce/views/admin/categories/:idcategory/products/:idproduct/remove", function($idcategory, $idproduct){

	User::verifylogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$product-> new Product();

	$product->get((int)$idproduct);

	$category->removeProduct($product);

	header("Location: /ecommerce/views/admin/categories/".$idcategory."/products");
	exit; 

}); 
?>