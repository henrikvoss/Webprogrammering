<?php
class Cart {
	private $cart = array();

	public function addToCart($key,$quantity) {
		if ( $_SESSION["style"][$key]->getStock() == 0 ) {
			return 0;
		} else {
			$avail =	$_SESSION["style"][$key]->getStock();

			if ($avail > $quantity) {
				$avail = $quantity;
			}

			$_SESSION["style"][$key]->updateStock(-$avail);

			if ( !isset($this->cart[$key]) ) {
				$this->cart[$key] = $avail;
			} else {
				$this->cart[$key] += $avail;
			}

			$_SESSION["style"][$key]->updateAmountInCart($avail);

			return $avail;
		}
	}

	public function deleteItem($key) {
		$quantityInCart = $_SESSION["style"][$key]->getAmountInCart();
		$_SESSION["style"][$key]->updateStock($quantityInCart);
		$_SESSION["style"][$key]->setAmountInCart(0);
		unset($this->cart[$key]);
	}

	public function getAmount($key) {
		return $this->cart[$key];
	}

	public function getCart() {
		return $this->cart;
	}

	public function setItemAmount($quantity,$key) {
		$this->cart[$key]->setAmountInCart($quantity);
		$this->cart[$key] = $quantity;
	}

	public function submitOrder() {
		/* Lager ordre av hele $cart arrayen. */
		/* Må lage ordrenr. ved å sjekke ordrenr av siste i historie-tabell += 
 		 * 1.
		 */
		$orderno = $_SESSION["database"]->getNewOrderNo();

		foreach ($this->cart as $key=>$quantity) {
			if ( $quantity > 0 ) {
				$sql = "insert into History values ($orderno, '".$_SESSION['style'][$key]->getName()."', '".$_SESSION['user']->getEmail()."', '".date( 'Y-m-d H:i:s', time() )."', $quantity)";
				
				$_SESSION["database"]->insertQuery($sql);
			}
			unset($this->cart[$key]);
		}
	}

	public function updateInCart($key,$amount) {
		if ($amount < 0){
			/* $amunt in this 'if' is negative. */
			if ( ($this->cart[$key] + $amount) < 1 ) {
				$_SESSION["style"][$key]->updateStock($this->cart[$key]);
				$_SESSION["style"][$key]->updateAmountInCart(0);
				$this->cart[$key] = 0;

			} else {

				/* '-' to get $amount positive: */
				$_SESSION["style"][$key]->updateStock(-$amount);
				$_SESSION["style"][$key]->updateAmountInCart($amount);
				$this->cart[$key] += $amount;
			}
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
				$_SESSION["style"][$key]->updateAmountInCart($avail);
				$this->cart[$key] += $avail;

				return $avail;
			}
		}
	}
}
?>
