<?php

/*

--- Part Two ---

You're curious how robust this security solution really is, and so you decide to find longer and longer paths which still provide access to the vault. You remember that paths always end the first time they reach the bottom-right room (that is, they can never pass through it, only end in it).

For example:

If your passcode were ihgpwlah, the longest path would take 370 steps.
With kglvqrro, the longest path would be 492 steps long.
With ulqzkmiv, the longest path would be 830 steps long.
What is the length of the longest path that reaches the vault?

Your puzzle input is still udskfozm.

*/

/*
#########
#S| | | #
#-#-#-#-#
# | | | #
#-#-#-#-#
# | | | #
#-#-#-#-#
# | | |  
####### V
*/

// real input
$INPUT = "udskfozm";
// test input
// $INPUT = "ulqzkmiv";

$PATH_ENDS = [[0,0,""]];
$CURRENT_DEPTH = 0;
$SUCCESS_PATHS = [];

while(count($PATH_ENDS) > 0) {

	$newEnds = [];
	$CURRENT_DEPTH += 1;
	foreach ($PATH_ENDS as $end) {

		if ($end[0] === 3 && $end[1] === 3) {
			$SUCCESS_PATHS[strlen($end[2])] = $end[2];
			continue;
		}

		// raw md5 of passcode
		$md5 = md5($INPUT.$end[2]);
		$canUp    = $end[1] >= 1 && $md5[0] >= "b" && $md5[0] <= "f"; 
		$canDown  = $end[1] <= 2 && $md5[1] >= "b" && $md5[1] <= "f"; 
		$canLeft  = $end[0] >= 1 && $md5[2] >= "b" && $md5[2] <= "f"; 
		$canRight = $end[0] <= 2 && $md5[3] >= "b" && $md5[3] <= "f"; 

		if ($canUp) {
			$newEnds[] = [$end[0],   $end[1]-1, $end[2]."U"];
		}
		if ($canDown) {
			$newEnds[] = [$end[0],   $end[1]+1, $end[2]."D"];
		}
		if ($canLeft) {
			$newEnds[] = [$end[0]-1, $end[1],   $end[2]."L"];
		}
		if ($canRight) {
		 	$newEnds[] = [$end[0]+1, $end[1],   $end[2]."R"];
		}

	}
	$PATH_ENDS = $newEnds;
}
ksort($SUCCESS_PATHS);
print_r($SUCCESS_PATHS);
