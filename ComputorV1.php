#!/usr/bin/php
<?php
class Equation {

	public function __construct($s) {
		$this->eqString = $s;

		// Add 's' for separation.
		$s = str_replace("+", "s+", $s);
		$s = str_replace("-", "s-", $s);

		// Get parts separated by '=' symbol.
		$this->leftparts = explode("s", explode("=", $s)[0]);
		$this->rightparts = explode("s", explode("=", $s)[1]);

		// Swaps parts if inverted.
		if (count($this->leftparts) < count($this->rightparts))
			$this->rightparts = [$this->leftparts, $this->leftparts = $this->rightparts][0];

		foreach($this->leftparts as $part) {
			if (preg_match("/X\^([0-9]+)/", $part, $degree)) {
				$val = preg_replace("/X\^([0-9]+)/", "", $part);
				$val = str_replace("*", "", $val);
				if (!is_numeric($val)) { 
					echo "Error in degree parsing, maybe because of a bad character?"."\n";
					exit();
				}
				if (intval($val) === 0) { continue; }
				$this->degrees[intval($degree[1])] = intval($val);
			}
		}
	}

	public function getReducedForm() {

	}

	public function getDegree() {
		$degree = max(array_keys($this->degrees));
		echo "Polynomial degree: ".$degree."\n";
	}

	public function solve() {

	}

	private function calculateDiscriminant() {

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

	if (preg_match("/[^0-9X*+\-\^=.]+/", $eqString) == 1 || strpos($eqString, '=') === false) {
		echo "Not a valid equation, unauthorized characters or missing \"=\" symbol."."\n";
		return;
	}

	$equation = new Equation($eqString);
	$equation->getReducedForm();
	$equation->getDegree();
}
