<?php

use \Hcode\PageAdmin;
use \Hcode\Model\User;

$app->get("admin/users", function(){

	User::verifylogin();

	$users = User::listAll();

	$page = new PageAdmin();

	$page->setTpl("users", array(
		"users"=>$users
	));

});

$app->get("admin/users/create", function(){

	User::verifylogin();

	$page = new PageAdmin();

	$page->setTpl("users-create");

});

$app->delete("/admin/users/:iduser/delete", function($iduser) {

	User::verifylogin();

	$user = new User();

	$user->get((int)$iduser);

	$user->delete();

	header("Location: /ecommerce/admin/users");
	exit;

});

$app->get("admin/users/:iduser", function($iduser){

	User::verifylogin();

	$user = new User();

	$user->get((int)$iduser);

	$page = new PageAdmin();

	$page->setTpl("users-update", array(
		"user"=>$user->getValues()
	));

});

$app->post("/admin/users/create", function() {

	User::verifylogin();

	$user = new User();

	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;

	$user->setData($_POST);

	$user->save();

	header("Location: /ecommerce/admin/users");
	exit;

});

$app->post("/admin/users/:iduser", function($iduser) {

	User::verifylogin();

	$user = new User();

	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;

	$user->get((int)$iduser);

	$user->setData($_POST);

	$user->update();

	header("Location: /ecommerce/admin/users");
	exit;

});


?>