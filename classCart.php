<?php
class Cart {
	private $cart = array();

	public function addToCart($key,$amount) {
		if ( $_SESSION["style"][$key]->getStock() == 0 ) {
			return false;
		} else {
			$avail =	$_SESSION["style"][$key]->getStock();

			$_SESSION["style"][$key]->updateStock(-$avail);

			if ( !isset($this->cart[$key]) ) {
				$this->cart[$key] = $_SESSION["style"][$key];
			}

			$this->cart[$key]->updateAmountInCart($avail);

			return $avail;
		}
	}

	public function getCart() {
		return $this->cart;
	}
}
?>
