<?php 
session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin; 
use \Hcode\Model\User;
use \Hcode\Model\Category;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	$page = new Page();   

	$page->setTpl("index");

});

$app->get('/admin', function() {

	User::verifylogin();
    
	$page = new PageAdmin();   

	$page->setTpl("index");

});

$app->get('/admin/login', function() {

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("login");

});

$app->post('/admin/login', function(){

	User::login($_POST["login"], $_POST["password"]);

	header("Location: /ecommerce/admin");
	exit;

});

$app->get('/admin/logout', function(){

	User::logout();

	header("Locatoin: /ecommerce/admin/login");
	exit;

});

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

$app->get("/admin/forgot", function(){

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("forgot"); 

});

$app->post("/admin/forgot", function(){

	$user = User::getForgot($_POST["email"]);

	header("Location: /ecommerce/admin/forgot/sent");
	exit;

});

$app->get("/ecommerce/admin/forgot/sent", function(){

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("forgot-send"); 

});

$app->get("/ecommerce/admin/forgot/reset", function(){

	$user = User::validForgotDecrypt($_GET["code"]);

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("forgot-reset", array(
		"name"=>$user["desperson"],
		"code"=>$_GET["code"]
	)); 

});

$app->post("/ecommerce/admin/forgot/reset", function(){

	$forgot = User::validForgotDecrypt($_POST["code"]);

	User::setforgotUsed($forgot["idrecovery"]);

	$user = new User();

	$user->get((int)$forgot["iduser"]);

	$password = password_hash($_POST["password"], PASSWORD_DEFAULT, [
		"cost"=>12
	]);

	$user->setPassword($password);
 
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("forgot-reset-success");

});

$app->get("/ecommerce/admin/categories", function(){

	User::verifylogin();

	$categories - Category::listAll();

	$page = new PageAdmin();
	 
	$page->setTpl("categories",
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

$app->run();

 ?>