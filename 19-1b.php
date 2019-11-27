<?php

/*

 
--- Day 19: An Elephant Named Joseph ---

The Elves contact you over a highly secure emergency channel. Back at the North Pole, the Elves are busy misunderstanding White Elephant parties.

Each Elf brings a present. They all sit in a circle, numbered starting with position 1. Then, starting with the first Elf, they take turns stealing all the presents from the Elf to their left. An Elf with no presents is removed from the circle and does not take turns.

For example, with five Elves (numbered 1 to 5):

  1
5   2
 4 3
Elf 1 takes Elf 2's present.
Elf 2 has no presents and is skipped.
Elf 3 takes Elf 4's present.
Elf 4 has no presents and is also skipped.
Elf 5 takes Elf 1's two presents.
Neither Elf 1 nor Elf 2 have any presents, so both are skipped.
Elf 3 takes Elf 5's three presents.
So, with five Elves, the Elf that sits starting in position 3 gets all the presents.

With the number of Elves given in your puzzle input, which Elf gets all the presents?

Your puzzle input is 3004953.


*/

$nRealElven = 3004953;
$nTestElven = 5;


$NUMBER_ELVES = $nRealElven;

/****
// solve algorithmically
// e.g. 15 elves
15: 1  1  1  1  1  1  1  1  1  1  1  1  1  1  1 
7:        2     2     2     2     2     2     3
3:                    4           4           7
1:                                           15

// e.g. 9 elves
9:  1  1  1  1  1  1  1  1  1 
4:        2     2     2     3
2:        4           5
1:        9

// e.g. 10 elves
10: 1  1  1  1  1  1  1  1  1  1 
5:  2     2     2     2     2
2:              4           6
1:              10
******/

// Leading elf always wins. So we need to keep track of who that will be.
// If the current number is even, the leading elf doesn't change
// If the current number is odd the leading elf goes up by a certain increment
// That increment is 2 to the power of the number of iterations.

$nRemainingElven = $NUMBER_ELVES;
$leadingElf = 1;
$nIncrement = 2;
while($nRemainingElven > 1) {

	if ($nRemainingElven % 2 === 0) {
		// even
		// divide by 2
		$nRemainingElven = $nRemainingElven / 2;
		// $elf with the most stays the same.
	} else {
		// odd 
		// divide by 2 and round down
		$nRemainingElven = floor($nRemainingElven / 2);
		// leading elf skips on
		$leadingElf += $nIncrement; 
	}

	$nIncrement *= 2;
}

echo "\n\nElf with all the presents is $leadingElf\n\n";


