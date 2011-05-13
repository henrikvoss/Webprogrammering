<?php

class Style {
	private $name;
	private $season;
	private $price;
	private $stock;
	private $imageUrl;
	private $sessionKey;
	private $amountInCart;

	function __construct($pName,$pSeas,$pPrice,$pStock,$pImg, $key) {
		$this->name = $pName;
		$this->season = $pSeas;
		$this->price = $pPrice;
		$this->stock = $pStock;
		$this->imageUrl = $pImg;
		$this->sessionKey = $key;
		$this->amountInCart = 0;
	}

	public function getAmountInCart() {
		return $this->amountInCart;
	}
	public function getImage() {
		return $this->imageUrl;
	}

	public function getName() {
		return $this->name;
	}

	public function getPrice() {
		return $this->price;
	}

	public function getSeason() {
		return $this->season;
	}

	public function getStock() {
		$sql = "select stock from Style where stylename = '$this->name'";
		return $_SESSION["database"]->getVar($sql);
	}

	public function setImage($newimg) {
		$this->imageUrl = $newimg;
	}

	public function setName($newname) {
		$this->name = $newname;
	}

	public function setPrice($newprice) {
		$this->price = $newprice;
	}

	public function setSeason($newseas) {
		$this->season = $newseas;
	}

	public function setStock($newstock) {
		$sql = "update Style set stock = $newstock where stylename = '$this->name'";
	}

	public function updateAmountInCart($int) {
		$this->amountInCart += $int;
	}

	public function updateStock($to) {
		$sql = "update Style set stock = stock + $to where stylename = $this->name";
		$result = $_SESSION["database"]->update($sql);
	}
}
?>
