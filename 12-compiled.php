<?php
$registers = ["a"=>0,"b"=>0,"c"=>1,"d"=>0];
label0:
	$registers['a'] = 1;
label1:
	$registers['b'] = 1;
label2:
	$registers['d'] = 26;
label3:
	if ($registers['c'] !== 0) {
		goto label5;
	}
label4:
		goto label9;
label5:
	$registers['c'] = 7;
label6:
	$registers['d'] += 1;
label7:
	$registers['c'] -= 1;
label8:
	if ($registers['c'] !== 0) {
		goto label6;
	}
label9:
	$registers['c'] = $registers['a'];
label10:
	$registers['a'] += 1;
label11:
	$registers['b'] -= 1;
label12:
	if ($registers['b'] !== 0) {
		goto label10;
	}
label13:
	$registers['b'] = $registers['c'];
label14:
	$registers['d'] -= 1;
label15:
	if ($registers['d'] !== 0) {
		goto label9;
	}
label16:
	$registers['c'] = 14;
label17:
	$registers['d'] = 14;
label18:
	$registers['a'] += 1;
label19:
	$registers['d'] -= 1;
label20:
	if ($registers['d'] !== 0) {
		goto label18;
	}
label21:
	$registers['c'] -= 1;
label22:
	if ($registers['c'] !== 0) {
		goto label17;
	}
labelEnd:
echo "\n\nProgram terminated. Register contents as follows:\n".json_encode($registers, JSON_PRETTY_PRINT)."\n\n";
