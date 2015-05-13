#!/usr/bin/php

class Equation {

	public function __contruct($s) {
		$this->eqString = s;
	}

	public function parseEqString() {

		// Add 's' for separation.
		$this->eqString = str_replace("+", "s+", $this->eqString);
		$this->eqString = str_replace("-", "s-", $this->eqString);

		// Get parts separated by '=' symbol.
		$leftparts = explode("s", explode("=", $this->eqString)[0]);
		$rightparts = explode("s", explode("=", $this->eqString)[1]);

		// Swaps parts if inverted.
		if (count($leftparts) < count($rightparts))
			$rightparts = [$leftparts, $leftparts = $rightparts][0];

		foreach(leftparts as part) {
			if (preg_match("/X\^0/g", part)) {
				
			}
			if (preg_match("/X\^1/g", part)) {
				
			}
			if (preg_match("/X\^2/g", part)) {
				
			}
			else {

			}
		}
	}

	public function calculateDiscriminant() {
		
	}
}
