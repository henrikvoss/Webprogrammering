<?php
class Cart {
	private $cart = array();

	public function addToCart($key,$amount) {
		if ( $_SESSION["style"]->getStock() == 0 ) {
			return false;
		} else {
			$_SESSION["style"][$key]->updateStock(-$amount);
			$cart[count($cart)] = $_SESSION["style"][$key];
			$cart[(count($cart)-1)]->updateAmountInCart($amount);
			return true;
		}
	}

	public function getCart() {
		return $this->cart;
	}
}
?>
