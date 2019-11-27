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

ini_set("memory_limit", "4096M");
$nRealElven = 3004953;
$nTestElven = 5;


$NUMBER_ELVES = $nRealElven;

$ELF_LINKED_LIST = [];
$ELF_LINKED_LIST[] = [$NUMBER_ELVES-1, 1, 1]; // previous Elf, nPresents, nextElf
// populate rest of linked list
for ($e=1; $e<($NUMBER_ELVES-1); ++$e) {
	$ELF_LINKED_LIST[] = [$e-1, 1, $e+1];
}
$ELF_LINKED_LIST[] = [$NUMBER_ELVES-2, 1, 0]; // previous Elf, nPresents, nextElf
echo "\nPrepared linked list\n";

$maxPresentCount = 0;

$elf = 0;
while(true) {

	// echo "$elf\n";
	// print_r($ELF_LINKED_LIST);
	// fgets(STDIN);

	$nextElf = $ELF_LINKED_LIST[$elf][2];
	$nextNextElf = $ELF_LINKED_LIST[$nextElf][2];

	// steal presents
	$ELF_LINKED_LIST[$elf][1] += $ELF_LINKED_LIST[$nextElf][1];

	// check for success
	if ($ELF_LINKED_LIST[$elf][1] === $NUMBER_ELVES) {
		echo "\n\nElf with all the presents is ".($elf+1)."\n\n";
		exit();
	} else if ( $maxPresentCount < $ELF_LINKED_LIST[$elf][1]) {
		$maxPresentCount = $ELF_LINKED_LIST[$elf][1];
		echo "Max presents: $maxPresentCount\n";
	}

	// set victim to zero (do we need to do this?)
	$ELF_LINKED_LIST[$nextElf][1] = 0;

	// remove victim from linked list by:
	// - setting next on current to nextnext
	$ELF_LINKED_LIST[$elf][2] = $nextNextElf;
	// - setting previous on nextnext to current
	$ELF_LINKED_LIST[$nextNextElf][0] = $elf;

	// set new elf to nextnext
	$elf = $nextNextElf;
}
