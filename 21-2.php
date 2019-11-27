<?php
/*
--- Part Two ---

You scrambled the password correctly, but you discover that you can't actually modify the password file on the system. You'll need to un-scramble one of the existing passwords by reversing the scrambling process.

What is the un-scrambled version of the scrambled password fbgdceah?

*/


$TEST_INPUT = "swap position 4 with position 0
swap letter d with letter b
reverse positions 0 through 4
rotate left 1 step
move position 1 to position 4
move position 3 to position 0
rotate based on position of letter b
rotate based on position of letter d";
$TEST_HASH = "decab";

$REAL_INPUT = "rotate left 2 steps
rotate right 0 steps
rotate based on position of letter a
rotate based on position of letter f
swap letter g with letter b
rotate left 4 steps
swap letter e with letter f
reverse positions 1 through 6
swap letter b with letter d
swap letter b with letter c
move position 7 to position 5
rotate based on position of letter h
swap position 6 with position 5
reverse positions 2 through 7
move position 5 to position 0
rotate based on position of letter e
rotate based on position of letter c
rotate right 4 steps
reverse positions 3 through 7
rotate left 4 steps
rotate based on position of letter f
rotate left 3 steps
swap letter d with letter a
swap position 0 with position 1
rotate based on position of letter a
move position 3 to position 6
swap letter e with letter g
move position 6 to position 2
reverse positions 1 through 2
rotate right 1 step
reverse positions 0 through 6
swap letter e with letter h
swap letter f with letter a
rotate based on position of letter a
swap position 7 with position 4
reverse positions 2 through 5
swap position 1 with position 2
rotate right 0 steps
reverse positions 5 through 7
rotate based on position of letter a
swap letter f with letter h
swap letter a with letter f
rotate right 4 steps
move position 7 to position 5
rotate based on position of letter a
reverse positions 0 through 6
swap letter g with letter c
reverse positions 5 through 6
reverse positions 3 through 5
reverse positions 4 through 6
swap position 3 with position 4
move position 4 to position 2
reverse positions 3 through 4
rotate left 0 steps
reverse positions 3 through 6
swap position 6 with position 7
reverse positions 2 through 5
swap position 2 with position 0
reverse positions 0 through 3
reverse positions 3 through 5
rotate based on position of letter d
move position 1 to position 2
rotate based on position of letter c
swap letter e with letter a
move position 4 to position 1
reverse positions 5 through 7
rotate left 1 step
rotate based on position of letter h
reverse positions 1 through 7
rotate based on position of letter f
move position 1 to position 5
reverse positions 1 through 4
rotate based on position of letter a
swap letter b with letter c
rotate based on position of letter g
swap letter a with letter g
swap position 1 with position 0
rotate right 2 steps
rotate based on position of letter f
swap position 5 with position 4
move position 1 to position 0
swap letter f with letter b
swap letter f with letter h
move position 1 to position 7
swap letter c with letter b
reverse positions 5 through 7
rotate left 6 steps
swap letter d with letter b
rotate left 3 steps
swap position 1 with position 4
rotate based on position of letter a
rotate based on position of letter a
swap letter b with letter c
swap letter e with letter f
reverse positions 4 through 7
rotate right 0 steps
reverse positions 2 through 3
rotate based on position of letter a
reverse positions 1 through 4
rotate right 1 step";
$REAL_HASH = "fbgdceah";
// $REAL_HASH = "gbhafcde"; // from part 1

// $INPUT = $TEST_INPUT;
// $HASH = $TEST_HASH;
$INPUT = $REAL_INPUT;
$HASH = $REAL_HASH;

$instructions = array_reverse(array_map("trim", explode("\n", trim($INPUT))));

function swapPosAWithB(&$password, $A, $B) {
	// swap position X with position Y means that the letters at indexes X and Y (counting from 0) should be swapped.
	$tmp = $password[$A];
	$password[$A] = $password[$B];
	$password[$B] = $tmp;
}
function swapLetterAWithB(&$password, $A, $B) {
	// swap letter X with letter Y means that the letters X and Y should be swapped (regardless of where they appear in the string).
	for ($n=0; $n<strlen($password); $n++) {
		if ($password[$n] == $A) {
			$password[$n] = $B;
		} else if ($password[$n] == $B) {
			$password[$n] = $A;
		}
	}
}
function reversePositionsAThroughB(&$password, $A, $B) {
	// reverse positions X through Y means that the span of letters at indexes X through Y (including the letters at X and Y) should be reversed in order.
	$reversedSection = strrev(substr($password, $A, $B-$A+1));
	$password = substr($password, 0, $A).$reversedSection.substr($password, $B+1);
}
function rotateNSteps(&$password, $DIRECTION, $N) {
	// rotate left/right X steps means that the whole string should be rotated; for example, one right rotation would turn abcd into dabc.

	$passwordArray = str_split($password);
	while($N--) {
		if ($DIRECTION === "left") {
			array_unshift($passwordArray, array_pop($passwordArray));
		} else if ($DIRECTION === "right") {
			array_push($passwordArray, array_shift($passwordArray));
		}
	}
	$password = implode("", $passwordArray);
}
function movePositionAToB(&$password, $A, $B) {
	// move position X to position Y means that the letter which is at index X should be removed from the string, then inserted such that it ends up at index Y.
	$passwordArray = str_split($password);
	$removed = array_splice($passwordArray, $B, 1);
	array_splice($passwordArray, $A, 0, $removed[0]);
	$password = implode("", $passwordArray);
}
function rotateBasedOnPosOfLetterA(&$password, $A) {
	// rotate based on position of letter X means that the whole string should be rotated to the right based on the index of letter X (counting from 0) as determined before this instruction does any rotations. Once the index is determined, rotate the string to the right one time, plus a number of times equal to that index, plus one additional time if the index was at least 4.

	$currentPos = strpos($password, $A);
	$leftRotations = 1;
	while (true) {
		$newPos = ($currentPos - $leftRotations + strlen($password)) % strlen($password);
		$calculatedCurrentPos = ($newPos + ($newPos >= 4 ? $newPos + 2 : $newPos + 1)) % strlen($password); 

		if ($calculatedCurrentPos == $currentPos) break;
		$leftRotations += 1;
	}

	// this func is reversed so we use a "right" rotate
	return rotateNSteps($password, "right", $leftRotations); 
}

foreach($instructions as $instruct) {

	if (preg_match("/^swap position ([0-9]+) with position ([0-9]+)$/", $instruct, $matches)) {
		swapPosAWithB($HASH, $matches[1], $matches[2]);
	} elseif (preg_match("/^swap letter ([a-zA-Z]+) with letter ([a-zA-Z]+)$/", $instruct, $matches)) {
		swapLetterAWithB($HASH, $matches[1], $matches[2]);
	} elseif (preg_match("/^reverse positions ([0-9]+) through ([0-9]+)$/", $instruct, $matches)) {
		reversePositionsAThroughB($HASH, $matches[1], $matches[2]);
	} elseif (preg_match("/^rotate (left|right) ([0-9]+) steps?$/", $instruct, $matches)) {
		rotateNSteps($HASH, $matches[1], $matches[2]);
	} elseif (preg_match("/^move position ([0-9]+) to position ([0-9]+)$/", $instruct, $matches)) {
		movePositionAToB($HASH, $matches[1], $matches[2]);
	} elseif (preg_match("/^rotate based on position of letter ([a-zA-Z]+)$/", $instruct, $matches)) {
		rotateBasedOnPosOfLetterA($HASH, $matches[1]);
	} else {
		die ("\n\nUnhandled instruction: ".$instruct."\n\n");
	} 
	echo "$HASH\n";
}

echo "\n\nUnscrambled password is $HASH\n\n";


