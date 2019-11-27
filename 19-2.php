<?php

/*

 
--- Part Two ---

Realizing the folly of their present-exchange rules, the Elves agree to instead steal presents from the Elf directly across the circle. If two Elves are across the circle, the one on the left (from the perspective of the stealer) is stolen from. The other rules remain unchanged: Elves with no presents are removed from the circle entirely, and the other elves move in slightly to keep the circle evenly spaced.

For example, with five Elves (again numbered 1 to 5):

The Elves sit in a circle; Elf 1 goes first:
  1
5   2
 4 3
Elves 3 and 4 are across the circle; Elf 3's present is stolen, being the one to the left. Elf 3 leaves the circle, and the rest of the Elves move in:
  1           1
5   2  -->  5   2
 4 -          4
Elf 2 steals from the Elf directly across the circle, Elf 5:
  1         1 
-   2  -->     2
  4         4 
Next is Elf 4 who, choosing between Elves 1 and 2, steals from Elf 1:
 -          2  
    2  -->
 4          4
Finally, Elf 2 steals from Elf 4:
 2
    -->  2  
 -
So, with five Elves, the Elf that sits starting in position 2 gets all the presents.

With the number of Elves given in your puzzle input, which Elf now gets all the presents?

Your puzzle input is still 3004953.



*/

/**
 * Print out solutions for 20,19,18,17,etc 
**/

function array_filter_and_count($arr)
{
	$arr = array_filter($arr, function($v) { return $v>0; });
	return count($arr);
}

for ($T=20; $T>=19; $T--) {

	$elves = array_fill(0, $T, 1);
	echo "    ";
	for ($n=1; $n<=$T; $n++) {
		echo str_pad($n, 3);
	}
	echo "\n";
	while(array_filter_and_count($elves) > 1) {
		echo str_pad(array_filter_and_count($elves), 4);
		foreach ($elves as $elf => $stash) {
			echo str_pad(($stash?$stash:" "), 3);
		}
		echo "\n";

		$thiefElf = null;
		for ($n=0; $n<$T; $n++) {
			if (!$elves[$n]) continue;
			$nRemaining = array_filter_and_count($elves);
			$half = floor($nRemaining / 2);
			$seen = 0;
			for ($m=$n; $m!=$n; ($m+=1)%$n) {
				if (!$elves[$m]) continue;
				$seen += 1;
				if ($seen = $half) {
					$elves[$n] + $elves[$m];
					break;
				}
			}
			if (!isset($thiefElf)) $thiefElf = $n;
			else {
				$elves[$thiefElf] += $elves[$n];
				$elves[$n] = 0;
				$thiefElf = null;
			}
		}

	}

	echo "\n\n\n";
}
exit();

$nRealElven = 3004953;
$nTestElven = 5;


$NUMBER_ELVES = $nRealElven;

/****
// solve algorithmically
// e.g. 15 elves
    1  2  3  4  5  6  7  8  9  10 11 12 13 14 15
15: 1  1  1  1  1  1  1  1  1  1  1  1  1  1  1 
5:        2        3        3        3        4 
2:                 7                 8          
1:                 15                           

// e.g. 16 elves
    1  2  3  4  5  6  7  8  9  10 11 12 13 14 15 16
16: 1  1  1  1  1  1  1  1  1  1  1  1  1  1  1  1
6:  2        2        3  3        3        3      
2:                    8                    8      
1:                    16                           

// e.g. 9 elves
    1  2  3  4  5  6  7  8  9
9:  1  1  1  1  1  1  1  1  1 
3:        2        3        4 
1:                          9 

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
		// divide byb 2 and round down
		$nRemainingElven = floor($nRemainingElven / 2);
		// leading elf skips on
		$leadingElf += $nIncrement; 
	}

	$nIncrement *= 2;
}

echo "\n\nElf with all the presents is $leadingElf\n\n";


