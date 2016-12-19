<?php

/*
--- Day 17: Two Steps Forward ---

You're trying to access a secure vault protected by a 4x4 grid of small rooms connected by doors. You start in the top-left room (marked S), and you can access the vault (marked V) once you reach the bottom-right room:

#########
#S| | | #
#-#-#-#-#
# | | | #
#-#-#-#-#
# | | | #
#-#-#-#-#
# | | |  
####### V
Fixed walls are marked with #, and doors are marked with - or |.

The doors in your current room are either open or closed (and locked) based on the hexadecimal MD5 hash of a passcode (your puzzle input) followed by a sequence of uppercase characters representing the path you have taken so far (U for up, D for down, L for left, and R for right).

Only the first four characters of the hash are used; they represent, respectively, the doors up, down, left, and right from your current position. Any b, c, d, e, or f means that the corresponding door is open; any other character (any number or a) means that the corresponding door is closed and locked.

To access the vault, all you need to do is reach the bottom-right room; reaching this room opens the vault and all doors in the maze.

For example, suppose the passcode is hijkl. Initially, you have taken no steps, and so your path is empty: you simply find the MD5 hash of hijkl alone. The first four characters of this hash are ced9, which indicate that up is open (c), down is open (e), left is open (d), and right is closed and locked (9). Because you start in the top-left corner, there are no "up" or "left" doors to be open, so your only choice is down.

Next, having gone only one step (down, or D), you find the hash of hijklD. This produces f2bc, which indicates that you can go back up, left (but that's a wall), or right. Going right means hashing hijklDR to get 5745 - all doors closed and locked. However, going up instead is worthwhile: even though it returns you to the room you started in, your path would then be DU, opening a different set of doors.

After going DU (and then hashing hijklDU to get 528e), only the right door is open; after going DUR, all doors lock. (Fortunately, your actual passcode is not hijkl).

Passcodes actually used by Easter Bunny Vault Security do allow access to the vault if you know the right path. For example:

If your passcode were ihgpwlah, the shortest path would be DDRRRD.
With kglvqrro, the shortest path would be DDUDRLRRUDRD.
With ulqzkmiv, the shortest would be DRURDRUDDLLDLUURRDULRLDUUDDDRR.
Given your vault's passcode, what is the shortest path (the actual path, not just the length) to reach the vault?

Your puzzle input is udskfozm.

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

while(count($PATH_ENDS) > 0) {

	$newEnds = [];
	$CURRENT_DEPTH += 1;
	foreach ($PATH_ENDS as $end) {

		if ($end[0] === 3 && $end[1] === 3) {
			echo "\n\nShortest path to reach vault is: ".$end[2]."\n\n";
			exit();
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
echo "\n\nPasscode is invalid :(\n\n";
