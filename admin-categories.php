<?php

use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Category;

$app->get("/ecommerce/admin/categories", function(){

	User::verifylogin();

	$categories - Category::listAll();

	$page = new PageAdmin();
	 
	$page->setTpl("categories",[
		'categories'=>$categories

	]);

});

$app->get("/ecommerce/admin/categories/create", function(){

	User::verifylogin();

	$page = new PageAdmin();
	 
	$page->setTpl("categories-create");

});

$app->post("/ecommerce/admin/categories/create", function(){

	User::verifylogin();

	$category = new Category();

	$category->setData($_POST);

	$category->save();

	header('Location: /ecommerce/admin/categories');
	exit;

});

$app->get("/ecommerce/admin/categories/:idcategory/delete", function($idcategory){

	User::verifylogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$category->delete();

	header('Location: /ecommerce/admin/categories');
	exit;

});

$app->get("/ecommerce/admin/categories/:idcategory/delete", function($idcategory){

	User::verifylogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$page = new PageAdmin();
	 
	$page->setTpl("categories-update", [
		'category'=>$category->getValues()
	]);

}); 


$app->post("/ecommerce/admin/categories/:idcategory/delete", function($idcategory){

	User::verifylogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$category->setData($_POST);

	$category->save();

	header('Location: /ecommerce/admin/categories');
	exit;

}); 

$app->get("/categories/:idcategory", function($idcategory){

	$category = new Category();

	$category->get((int)$idcategory);

	$page = new Page();

	$page->setTpl("category", [
		'category'=>$category->getValues(),
		'products'=>[]
	]);

});

?>