<?php
class Cart {
	private $cart = array();

	public function addToCart($key,$amount) {
		if ( $_SESSION["style"][$key]->getStock() == 0 ) {
			return 0;
		} else {
			$avail =	$_SESSION["style"][$key]->getStock();

			if ($avail > $amount) {
				$avail = $amount;
			}

			$_SESSION["style"][$key]->updateStock(-$avail);

			if ( !isset($this->cart[$key]) ) {
				$this->cart[$key] = $_SESSION["style"][$key];
			}

			$this->cart[$key]->updateAmountInCart($avail);

			return $avail;
		}
	}

	public function deleteItem($key) {
		unset($this->cart[$key]);
	}

	public function getAmount($key) {
		return $this->cart[$key]->getAmountInCart();
	}
	public function getCart() {
		return $this->cart;
	}

	public function setItemAmount($amount,$key) {
		$this->cart[$key]->setAmountInCart($amount);
	}

	public function updateInCart($key,$amount) {
		if ($amount < 0){
			/* $amunt in this if is negative. */
			if ( ($this->cart[$key]->getAmountInCart() + $amount) < 0 ) {
				$amount = -($this->cart[$key]->getAmountInCart());
			}
			/* '-' to get $amount positive: */
			$_SESSION["style"][$key]->updateStock(-$amount);
			$this->cart[$key]->updateAmountInCart($amount);
			return -1;

		} else {

			if ( $_SESSION["style"][$key]->getStock() == 0 ) {
				return 0;

			} else {
				$avail =	$_SESSION["style"][$key]->getStock();

				if ($avail > $amount) {
					$avail = $amount;
				}

				$_SESSION["style"][$key]->updateStock(-$avail);
				$this->cart[$key]->updateAmountInCart($avail);

				return $avail;
			}
		}
	}
}
?>
