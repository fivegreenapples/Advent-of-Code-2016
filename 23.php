<?php


/*

--- Day 23: Safe Cracking ---

This is one of the top floors of the nicest tower in EBHQ. The Easter Bunny's private office is here, complete with a safe hidden behind a painting, and who wouldn't hide a star in a safe behind a painting?

The safe has a digital screen and keypad for code entry. A sticky note attached to the safe has a password hint on it: "eggs". The painting is of a large rabbit coloring some eggs. You see 7.

When you go to type the code, though, nothing appears on the display; instead, the keypad comes apart in your hands, apparently having been smashed. Behind it is some kind of socket - one that matches a connector in your prototype computer! You pull apart the smashed keypad and extract the logic circuit, plug it into your computer, and plug your computer into the safe.

Now, you just need to figure out what output the keypad would have sent to the safe. You extract the assembunny code from the logic chip (your puzzle input).
The code looks like it uses almost the same architecture and instruction set that the monorail computer used! You should be able to use the same assembunny interpreter for this as you did there, but with one new instruction:

tgl x toggles the instruction x away (pointing at instructions like jnz does: positive means forward; negative means backward):

For one-argument instructions, inc becomes dec, and all other one-argument instructions become inc.
For two-argument instructions, jnz becomes cpy, and all other two-instructions become jnz.
The arguments of a toggled instruction are not affected.
If an attempt is made to toggle an instruction outside the program, nothing happens.
If toggling produces an invalid instruction (like cpy 1 2) and an attempt is later made to execute that instruction, skip it instead.
If tgl toggles itself (for example, if a is 0, tgl a would target itself and become inc a), the resulting instruction is not executed until the next time it is reached.
For example, given this program:

cpy 2 a
tgl a
tgl a
tgl a
cpy 1 a
dec a
dec a
cpy 2 a initializes register a to 2.
The first tgl a toggles an instruction a (2) away from it, which changes the third tgl a into inc a.
The second tgl a also modifies an instruction 2 away from it, which changes the cpy 1 a into jnz 1 a.
The fourth line, which is now inc a, increments a to 3.
Finally, the fifth line, which is now jnz 1 a, jumps a (3) instructions ahead, skipping the dec a instructions.
In this example, the final value in register a is 3.

The rest of the electronics seem to place the keypad entry (the number of eggs, 7) in register a, run the code, and then send the value left in register a to the safe.

What value should be sent to the safe?

--- Part Two ---

The safe doesn't open, but it does make several angry noises to express its frustration.

You're quite sure your logic is working correctly, so the only other thing is... you check the painting again. As it turns out, colored eggs are still eggs. Now you count 12.

As you run the program with this new input, the prototype computer begins to overheat. You wonder what's taking so long, and whether the lack of any instruction more powerful than "add one" has anything to do with it. Don't bunnies usually multiply?

Anyway, what value should actually be sent to the safe?



*/

$TEST_INPUT = "cpy 2 a
tgl a
tgl a
tgl a
cpy 1 a
dec a
dec a
";
$DAY12_INPUT = "cpy 1 a
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
$REAL_INPUT = "cpy a b
dec b
cpy a d
cpy 0 a
cpy b c
inc a
dec c
jnz c -2
dec d
jnz d -5
dec b
cpy b c
cpy c d
dec d
inc c
jnz d -2
tgl c
cpy -16 c
jnz 1 c
cpy 90 c
jnz 73 d
inc a
inc d
jnz d -2
inc c
jnz c -5";

$INPUT = $DAY12_INPUT;



$instructions = array_map("trim", explode("\n", trim($INPUT)));
$program = [];

foreach ($instructions as $index => $instruct) {
	if (preg_match("/([a-z]+) (-?[a-z0-9]+)( (-?[a-z0-9]+))?$/", $instruct, $matches)) {
		if (!in_array($matches[1], ["inc","dec","tgl","jnz","cpy"])) {
			die ("\n\nUnhandled instruction $instruct at line $index\n\n");
		}

		$opcode = $matches[1];
		$op1 = $op2 = null;
		if (is_numeric($matches[2])) {
			$opcode .= "num";
			$op1 = intval($matches[2]);
		} else {
			$opcode .= "reg";
			$op1 = $matches[2];
		}
		if (!empty($matches[3])) {
			if (is_numeric($matches[4])) {
				$opcode .= "num";
				$op2 = intval($matches[4]);
			} else {
				$opcode .= "reg";
				$op2 = $matches[4];
			}
		}

		$program[] = [$opcode, $op1, $op2];

	} else {
		die ("\n\nUnhandled instruction $instruct at line $index\n\n");
	}
}
// day 1
$programLength = count($program);
// part 1
// $registers = ["a"=>7,"b"=>0,"c"=>0,"d"=>0];
// part 2
// $registers = ["a"=>12,"b"=>0,"c"=>0,"d"=>0];
// day 12
$registers = ["a"=>0,"b"=>0,"c"=>1,"d"=>0];
$pc = -1;
run:
	$pc += 1;
	if ($pc >= $programLength) goto end;

	$op1 = $program[$pc][1];
	$op2 = $program[$pc][2];
	switch($program[$pc][0]) {
		case "increg":
		goto labelincreg;
		break;
		case "decreg":
		goto labeldecreg;
		break;
		case "incnum":
		goto labelincnum;
		break;
		case "decnum":
		goto labeldecnum;
		break;
		case "cpyregreg":
		goto labelcpyregreg;
		break;
		case "cpyregnum":
		goto labelcpyregnum;
		break;
		case "cpynumreg":
		goto labelcpynumreg;
		break;
		case "cpynumnum":
		goto labelcpynumnum;
		break;
		case "jnzregreg":
		goto labeljnzregreg;
		break;
		case "jnzregnum":
		goto labeljnzregnum;
		break;
		case "jnznumreg":
		goto labeljnznumreg;
		break;
		case "jnznumnum":
		goto labeljnznumnum;
		break;
		case "tglreg":
		goto labeltglreg;
		break;
		case "tglnum":
		goto labeltglnum;
		break;
		default:
		die("\n\nError! ".print_r($program[$pc]));
	}

end:

echo "\n\nProgram terminated. Register contents as follows:\n".json_encode($registers, JSON_PRETTY_PRINT)."\n\n";

exit();

labelincreg:
	$registers[$op1] += 1;
	goto run;

labeldecreg:
	$registers[$op1] -= 1;
	goto run;

labelincnum:
	goto run;

labeldecnum:
	goto run;

labelcpyregreg:
	$registers[$op2] = $registers[$op1];
	goto run;

labelcpyregnum:
	goto run;

labelcpynumreg:
	$registers[$op2] = $op1;
	goto run;

labelcpynumnum:
	goto run;


labeljnzregreg:
	if ($registers[$op1] !== 0) {
		$pc += ($registers[$op2] - 1);
	}
	goto run;

labeljnzregnum:
	if ($registers[$op1] !== 0) {
		$pc += ($op2 - 1);
	}
	goto run;

labeljnznumreg:
	if ($op1 !== 0) {
		$pc += ($registers[$op2] - 1);
	}
	goto run;

labeljnznumnum:
	if ($op1 !== 0) {
		$pc += ($op2 - 1);
	}
	goto run;

labeltglreg:
	$togglepc = $pc + $registers[$op1];
	goto tgl;
labeltglnum:
	$togglepc = $pc + $op1;
tgl:
	if (!isset($program[$togglepc])) goto run;
	switch($program[$togglepc][0]) {
		case "increg":
		$program[$togglepc][0] = "decreg";
		break;
		case "decreg":
		$program[$togglepc][0] = "increg";
		break;
		case "incnum":
		$program[$togglepc][0] = "decnum";
		break;
		case "decnum":
		$program[$togglepc][0] = "incnum";
		break;
		case "cpyregreg":
		$program[$togglepc][0] = "jnzregreg";
		break;
		case "cpyregnum":
		$program[$togglepc][0] = "jnzregnum";
		break;
		case "cpynumreg":
		$program[$togglepc][0] = "jnznumreg";
		break;
		case "cpynumnum":
		$program[$togglepc][0] = "jnznumnum";
		break;
		case "jnzregreg":
		$program[$togglepc][0] = "cpyregreg";
		break;
		case "jnzregnum":
		$program[$togglepc][0] = "cpyregnum";
		break;
		case "jnznumreg":
		$program[$togglepc][0] = "cpynumreg";
		break;
		case "jnznumnum":
		$program[$togglepc][0] = "cpynumnum";
		break;
		case "tglreg":
		$program[$togglepc][0] = "increg";
		break;
		case "tglnum":
		$program[$togglepc][0] = "incnum";
		break;
		default:
		die("\n\nError at line $pc \n".print_r($registers, true)."\n".print_r($program, true)."\n\n");
	}
	goto run;


