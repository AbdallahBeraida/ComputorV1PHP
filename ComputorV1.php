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
		//if (count($this->leftparts) < count($this->rightparts))
		//	$this->rightparts = [$this->leftparts, $this->leftparts = $this->rightparts][0];

		foreach($this->leftparts as $part) {
			if (preg_match("/X\^([0-9]+)/", $part, $degree)) {
				$val = preg_replace("/X\^([0-9]+)/", "", $part);
				$val = str_replace("*", "", $val);
				if (!is_numeric($val)) { 
					echo "Error in degree parsing, maybe because of a bad character?"."\n";
					exit();
				}
				if (floatval($val) === (float)0) { continue; }
				$this->leftdegrees[intval($degree[1])] = floatval($val);
			}
		}

		foreach($this->rightparts as $part) {
			if (preg_match("/X\^([0-9]+)/", $part, $degree)) {
				$val = preg_replace("/X\^([0-9]+)/", "", $part);
				$val = str_replace("*", "", $val);
				if (!is_numeric($val)) { 
					echo "Error in degree parsing, maybe because of a bad character?"."\n";
					exit();
				}
				if (floatval($val) === (float)0) { continue; }
				$this->rightdegrees[intval($degree[1])] = floatval($val);
			}
		}
	}

	public function getReducedForm() {
		$this->reducedform = $this->leftdegrees;
		foreach($this->rightdegrees as $key => $value) {
			if (isset($this->reducedform[$key])) { $this->reducedform[$key] -= $value; }
			else { $this->reducedform[$key] = 0 - $value; }
			if ( $this->reducedform[$key] == 0 && $key != 0) { unset($this->reducedform[$key]); }
		}
		echo "Reduced form: ";
		foreach($this->reducedform as $key => $value) {
			if ($value > 0) { echo "+"; }
			echo $value." * X^".$key." ";
		}
		echo "= 0"."\n";
	}

	public function getDegree() {

		$this->degree = max(array_keys($this->reducedform));
		echo "Polynomial degree: ".$this->degree."\n";
	}

	public function solve() {
		if ($this->degree == 0) {
			if ($this->reducedform[0] == 0)
				echo "All real numbers are solutions."."\n";
			else
				echo "This equation has no solutions."."\n";
		}
		else if ($this->degree == 1) {
			$x = $this->reducedform[0] / -$this->reducedform[1];
			echo "The solution is:"."\n".$x."\n";
		}
		else if ($this->degree == 2) {
			$delta = $this->getDelta();
			if ($delta > 0){
				$s1 = (-$this->reducedform[1] + my_sqrt($delta, 8)) / ($this->reducedform[2] * 2);
				$s2 = (-$this->reducedform[1] - my_sqrt($delta, 8)) / ($this->reducedform[2] * 2);
				echo "Discriminant is ".$delta.", strictly positive, the two solutions are: "."\n";
				echo $s1."\n".$s2."\n";
			}
			else if ($delta < 0){
				$s = -$this->reducedform[1] / ($this->reducedform[2] * 2);
				echo "Discriminant is ".$delta.", strictly negative, the two imaginaries solutions are: "."\n";
				printf("%s + i * %s\n", -$this->reducedform[1] / 2 * $this->reducedform[2], my_sqrt(-$delta, 8) / 2 * $this->reducedform[2]);

				printf("%s - i * %s\n", -$this->reducedform[1] / 2 * $this->reducedform[2], my_sqrt(-$delta, 8) / 2 * $this->reducedform[2]);
			}
			else {
				$s1 = -$this->reducedform[1] / 2 * $this->reducedform[2];
				echo "Discriminant is 0, the solution is: "."\n";
				echo $s1."\n";
			}
		}
		else
			echo "The polynomial degree is stricly greater than 2, I can't solve."."\n";
	}

	private function getDelta() {
		$delta = $this->reducedform[1] * $this->reducedform[1] - 4 * $this->reducedform[2] * $this->reducedform[0];
		return $delta;
	}
}

function my_sqrt($number, $precision) {
	$x = $number;
	$i = 0;

	if ($number <= 0)
		return 0;
	while ($i < $precision){
		$x = ($x + ($number / $x)) / 2;
		$i++;
	}
	return $x;
}

function checkArgs($args)
{
	if (count($args) > 2)
		echo "Too much arguments"."\n";
	else if (count($args) < 2)
		echo "Please specify an equation"."\n";
	else
		return(0);
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
	$equation->solve();
}
