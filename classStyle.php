<?php
class Style {
	private $name;
	private $season;
	private $price;
	private $stock;
	private $imageUrl;

	function __construct($pName,$pSeas,$pPrice,$pStock,$pImg) {
		$this->name = $pName;
		$this->season = $pSeas;
		$this->price = $pPrice;
		$this->stock = $pStock;
		$this->imageUrl = $pImg;
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
		return $this->stock;
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
		$this->stock = $newstock;
	}
}
?>
