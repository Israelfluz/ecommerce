<?php

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;
use \Hcode\Mailer; 

class Product extends Model {

	public static function listAll()
	{

		$sql = new Sql();

		return $sql ->select("SELECT * FROM tb_product ORDER BY desproduct");

	}

	public static function checklist($list)
	{

		foreach ($list as &$row) {
			
			$p = new Product();
			$p->setData($row);
			$row = $p->getValeus();

		}

		return $list;

	}

	public function save();
	{

		$sql = new Sql();
		
		$results = $sql->select("CALL sp_product_save(:idproduct, :desproduct, :vlprice, :vlwidth, :vlheigth, :vllength, :vlweigth, :desurl)", array(
			":idproduct"=>$this->getidproduct(),
			":desproduct"=>$this->getdesproduct(),
			":vlprice"=>$this->getvlprice(),
			":vlwidth"=>$this->getvlwidth(),
			":vlheigth"=>$this->getvlheigth(),
			":vllength"=>$this->getvllength(),
			":vlweigth"=>$this->getvlweigth(),
			":desurl"=>$this->getdesurl()
		));

		$this->setData($results[0]);
	}

	public function get($idproduct)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_products WHERE idproduct = :idproduct", [
			':idproduct'=>$idproduct
		]);

		$this->setData($results[0]);
	}
	
	public function delete()
	{

		$sql = new Sql();

		$sql->query("DELETE FROM tb_products WHERE idproduct = :idproduct",[
			':idproduct'=>$this->getidproduct()
		]);

	
	}

	public function checkPhoto()
	{

		if (file_exists(
			$_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 
			"resource" . DIRECTORY_SEPARATOR . 
			"site" . DIRECTORY_SEPARATOR . 
			"img" . DIRECTORY_SEPARATOR . 
			"products" . DIRECTORY_SEPARATOR . 
			$this->getidproduct() . ".jpg"
			)) {

			$url = "/ecommercer/resource/site/img/products/" . $this->getidproduct() . ".jpg";

		} else {

			$url = "/ecommercer/resource/site/img/product.jpg";
		}

		return $this->setdesPhoto($url);

	}

	public function getValeus()
	{

		$this->checkPhoto();

		$values = parents::getValeus();

		return $values;

	}

	public function setPhoto($file)
	{

		$extension = explode('.', $file['name']);
		$extension = end($extension);

		switch ($extension) {

			case "jpg":
			case "jpeg":
			$image = imagecreatefromjpeg($file["tmp_name"]);
			break;

			case "gif":
			$image = imagecreatefromgif($file["tmp_name"]);
			break;

			case "png":
			$image = imagecreatefrompng($file["tmp_name"]);
			break;
		

		}

		$dist = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 
			"resource" . DIRECTORY_SEPARATOR . 
			"site" . DIRECTORY_SEPARATOR . 
			"img" . DIRECTORY_SEPARATOR . 
			"products" . DIRECTORY_SEPARATOR . 
			$this->getidproduct() . ".jpg"

		imagejpeg($image, $dist);

		imagedestroy($image);

		$this->checkPhoto();

	}

	public function getFromURL($desurl)
	{

		$sql = new Sql();

		$row = $sql->select("SELECT * FROM tb_products WHERE desurl = :desurl LIMIT 1", [
			':desurl'=>$desurl
		]);

		$this->setData($row[0]);
	
	
	}

	public function getCategories()
	{

		$sql = new Sql();

		return $sql->select("
			SELECT * FROM tb_categories a INNER JOIN tb_productscategories b ON a.idcategory = b.idcategory WHERE b.idproduct = :idproduct
		", [

			':idproduct'=>$this->getidproduct()
		]);
	}
}

?>

