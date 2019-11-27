<?php
function instruct0() {
	global $registers;
	$registers['a'] = 1;
	return 1;
}
function instruct1() {
	global $registers;
	$registers['b'] = 1;
	return 1;
}
function instruct2() {
	global $registers;
	$registers['d'] = 26;
	return 1;
}
function instruct3() {
	global $registers;
	if ($registers['c'] !== 0) {
		return 2;
	}
	return 1;
}
function instruct4() {
	global $registers;
	return 5;
}
function instruct5() {
	global $registers;
	$registers['c'] = 7;
	return 1;
}
function instruct6() {
	global $registers;
	$registers['d'] += 1;
	return 1;
}
function instruct7() {
	global $registers;
	$registers['c'] -= 1;
	return 1;
}
function instruct8() {
	global $registers;
	if ($registers['c'] !== 0) {
		return -2;
	}
	return 1;
}
function instruct9() {
	global $registers;
	$registers['c'] = $registers['a'];
	return 1;
}
function instruct10() {
	global $registers;
	$registers['a'] += 1;
	return 1;
}
function instruct11() {
	global $registers;
	$registers['b'] -= 1;
	return 1;
}
function instruct12() {
	global $registers;
	if ($registers['b'] !== 0) {
		return -2;
	}
	return 1;
}
function instruct13() {
	global $registers;
	$registers['b'] = $registers['c'];
	return 1;
}
function instruct14() {
	global $registers;
	$registers['d'] -= 1;
	return 1;
}
function instruct15() {
	global $registers;
	if ($registers['d'] !== 0) {
		return -6;
	}
	return 1;
}
function instruct16() {
	global $registers;
	$registers['c'] = 14;
	return 1;
}
function instruct17() {
	global $registers;
	$registers['d'] = 14;
	return 1;
}
function instruct18() {
	global $registers;
	$registers['a'] += 1;
	return 1;
}
function instruct19() {
	global $registers;
	$registers['d'] -= 1;
	return 1;
}
function instruct20() {
	global $registers;
	if ($registers['d'] !== 0) {
		return -2;
	}
	return 1;
}
function instruct21() {
	global $registers;
	$registers['c'] -= 1;
	return 1;
}
function instruct22() {
	global $registers;
	if ($registers['c'] !== 0) {
		return -5;
	}
	return 1;
}
$registers = ["a"=>0,"b"=>0,"c"=>1,"d"=>0];
$pc = 0;
while ($pc<23) {
	$instructFunc = "instruct".$pc;
	$pc += $instructFunc();
}
echo "\n\nProgram terminated. Register contents as follows:\n".json_encode($registers, JSON_PRETTY_PRINT)."\n\n";
