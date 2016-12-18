<?php


/*

--- Day 12: Leonardo's Monorail ---

You finally reach the top floor of this building: a garden with a slanted glass ceiling. Looks like there are no more stars to be had.

While sitting on a nearby bench amidst some tiger lilies, you manage to decrypt some of the files you extracted from the servers downstairs.

According to these documents, Easter Bunny HQ isn't just this building - it's a collection of buildings in the nearby area. They're all connected by a local monorail, and there's another building not far from here! Unfortunately, being night, the monorail is currently not operating.

You remotely connect to the monorail control systems and discover that the boot sequence expects a password. The password-checking logic (your puzzle input) is easy to extract, but the code it uses is strange: it's assembunny code designed for the new computer you just assembled. You'll have to execute the code and get the password.

The assembunny code you've extracted operates on four registers (a, b, c, and d) that start at 0 and can hold any integer. However, it seems to make use of only a few instructions:

cpy x y copies x (either an integer or the value of a register) into register y.
inc x increases the value of register x by one.
dec x decreases the value of register x by one.
jnz x y jumps to an instruction y away (positive means forward; negative means backward), but only if x is not zero.
The jnz instruction moves relative to itself: an offset of -1 would continue at the previous instruction, while an offset of 2 would skip over the next instruction.

For example:

cpy 41 a
inc a
inc a
dec a
jnz a 2
dec a
The above code would set register a to 41, increase its value by 2, decrease its value by 1, and then skip the last dec a (because a is not zero, so the jnz a 2 skips it), leaving register a at 42. When you move past the last instruction, the program halts.

After executing the assembunny code in your puzzle input, what value is left in register a?

--- Part Two ---

As you head down the fire escape to the monorail, you notice it didn't start; register c needs to be initialized to the position of the ignition key.

If you instead initialize register c to be 1, what value is now left in register a?


*/

$TEST_INPUT = "cpy 41 a
inc a
inc a
dec a
jnz a 2
dec a
";
$INPUT = "cpy 1 a
cpy 1 b
cpy 26 d
jnz c 2
jnz 1 5
cpy 7 c
inc d
dec c
jnz c -2
cpy a c
inc a
dec b
jnz b -2
cpy c b
dec d
jnz d -6
cpy 14 c
cpy 14 d
inc a
dec d
jnz d -2
dec c
jnz c -5";

function run($instructions) {

	$instructions = array_map("trim", explode("\n", trim($instructions)));

	// day 1
	$registers = ["a"=>0,"b"=>0,"c"=>0,"d"=>0];
	// day 2
	$registers = ["a"=>0,"b"=>0,"c"=>1,"d"=>0];
	$pc = 0;
	while ($pc<count($instructions)) {
		$instruct = $instructions[$pc];

		if (preg_match("/^cpy ([0-9]+) ([a-z]+)$/", $instruct, $matches)) {
			// cpy 41 a
			$val = intval($matches[1]);
			$registers[$matches[2]] = $val;;
		} elseif (preg_match("/^cpy ([a-z]+) ([a-z]+)$/", $instruct, $matches)) {
			// cpy b a
			if (!isset($registers[$matches[1]])) die("\n\nError at line $pc: $instruct - Register not populated!\n\n");
			$val = $registers[$matches[1]];
			$registers[$matches[2]] = $val;;
		} elseif (preg_match("/^inc ([a-z]+)$/", $instruct, $matches)) {
			// inc a
			if (!isset($registers[$matches[1]])) die("\n\nError at line $pc: $instruct - Register not populated!\n\n");
			$registers[$matches[1]] += 1;
		} elseif (preg_match("/^dec ([a-z]+)$/", $instruct, $matches)) {
			// dec a
			if (!isset($registers[$matches[1]])) die("\n\nError at line $pc: $instruct - Register not populated!\n\n");
			$registers[$matches[1]] -= 1;
		} elseif (preg_match("/^jnz ([a-z]+) (-?[0-9]+)$/", $instruct, $matches)) {
			// jnz a 2
			if (!isset($registers[$matches[1]])) die("\n\nError at line $pc: $instruct - Register not populated!\n\n");
			$testReg = $matches[1];
			$jump = intval($matches[2]);
			if ($registers[$testReg] !== 0) {
				$pc = $pc + $jump;
				continue;
			}
		} elseif (preg_match("/^jnz ([0-9]+) (-?[0-9]+)$/", $instruct, $matches)) {
			// jnz 1 5
			$testVal = intval($matches[1]);
			$jump = intval($matches[2]);
			if ($testVal !== 0) {
				$pc = $pc + $jump;
				continue;
			}
		} else {
			die("\n\nError at line $pc: $instruct - Unhandled instruction!\n\n");
		} 
		
		$pc += 1;

	}

	echo "\n\nProgram terminated. Register contents as follows:\n".json_encode($registers, JSON_PRETTY_PRINT)."\n\n";

}

run($TEST_INPUT);
run($INPUT);

