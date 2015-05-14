#!/usr/bin/php
<?php
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

		foreach($leftparts as $part) {
			if (strpos($part, "X^0") !== false) {
				$part = str_replace("X^0", "", $part);
				$part = str_replace("*", "", $part);
				$this->c = $part;
			}
			if (strpos($part, "X^1") !== false) {
				$part = str_replace("X^1", "", $part);
				$part = str_replace("*", "", $part);
				$this->b = $part;
			}
			if (strpos($part, "X^2") !== false) {
				$part = str_replace("X^2", "", $part);
				$part = str_replace("*","", $part);
				$this->a = $part;
			}
			else {
				echo "Parse error, you may have forgotten a pow in the equation"."\n";
			}
		}
		echo "a=".$this->a.", b=".$this->b.", c=".$this->c;
	}

	public function calculateDiscriminant() {

	}
}

function checkArgs($args)
{
	if (count($args) > 2) {
		echo "Too much arguments"."\n";
	}
	else if (count($args) < 2) {
		echo "Please specify an equation"."\n";
	}
	else {
		return(0);
	}
	return(1);
}

if (!checkArgs($argv)) {
	$eqString = $argv[1];

	// Remove spaces
	$eqString = str_replace(" ", "", $eqString);

	if (preg_match("/[^0-9X*+\-\^=.]/", $eqString) == 1 || (strpos($eqString, '=') === false)) {
		echo "Not a valid equation, unauthorized characters or missing \"=\" symbol."."\n";
		return;
	}

	$equation = new Equation($eqString);
	$equation->parseEqString();
}
