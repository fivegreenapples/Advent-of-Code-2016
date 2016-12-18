<?php

/*
--- Day 13: A Maze of Twisty Little Cubicles ---

You arrive at the first floor of this new building to discover a much less welcoming environment than the shiny atrium of the last one. Instead, you are in a maze of twisty little cubicles, all alike.

Every location in this area is addressed by a pair of non-negative integers (x,y). Each such coordinate is either a wall or an open space. You can't move diagonally. The cube maze starts at 0,0 and seems to extend infinitely toward positive x and y; negative values are invalid, as they represent a location outside the building. You are in a small waiting area at 1,1.

While it seems chaotic, a nearby morale-boosting poster explains, the layout is actually quite logical. You can determine whether a given x,y coordinate will be a wall or an open space using a simple system:

Find x*x + 3*x + 2*x*y + y + y*y.
Add the office designer's favorite number (your puzzle input).
Find the binary representation of that sum; count the number of bits that are 1.
If the number of bits that are 1 is even, it's an open space.
If the number of bits that are 1 is odd, it's a wall.
For example, if the office designer's favorite number were 10, drawing walls as # and open spaces as ., the corner of the building containing 0,0 would look like this:

  0123456789
0 .#.####.##
1 ..#..#...#
2 #....##...
3 ###.#.###.
4 .##..#..#.
5 ..##....#.
6 #...##.###
Now, suppose you wanted to reach 7,4. The shortest route you could take is marked as O:

  0123456789
0 .#.####.##
1 .O#..#...#
2 #OOO.##...
3 ###O#.###.
4 .##OO#OO#.
5 ..##OOO.#.
6 #...##.###
Thus, reaching 7,4 would take a minimum of 11 steps (starting from your current location, 1,1).

What is the fewest number of steps required for you to reach 31,39?
Your puzzle input is 1352.


*/

$INPUT = 1352;
$TEST_INPUT = 10;
$TARGET = [31,39];

$MAZE = [];
// pre generate maze walls
for ($x=0; $x<256; $x++) {
	for ($y=0; $y<256; $y++) {
		// Find x*x + 3*x + 2*x*y + y + y*y.
		$val = ($x*$x) + (3*$x) + (2*$x*$y) + ($y) + ($y*$y);
		// Add the office designer's favorite number (your puzzle input).
		$val += $INPUT;
		// Find the binary representation of that sum; count the number of bits that are 1.
		$binVal = decbin($val);
		$binValBits = str_split($binVal);
		$nHighBits = array_sum($binValBits);
		// If the number of bits that are 1 is even, it's an open space.
		// If the number of bits that are 1 is odd, it's a wall.
		$isWall = ($nHighBits % 2) !== 0; 

		$key = $x + ($y << 16);
		$MAZE[$key] = $isWall;
	}	
}

function printMaze($extentX, $extentY) {
	global $MAZE, $TARGET;
	echo "    ";
	for ($x=0; $x<$extentX; $x++) {
		$digit = (floor($x/100) % 10); 
		echo ($digit === 0) ? " " : $digit;
	}
	echo "\n";
	echo "    ";
	for ($x=0; $x<$extentX; $x++) {
		$digit = (floor($x/10) % 10); 
		echo ($digit === 0) ? " " : $digit;
	}
	echo "\n";
	echo "    ";
	for ($x=0; $x<$extentX; $x++) {
		echo ($x % 10);
	}
	echo "\n";
	for ($y=0; $y<$extentY; $y++) {
		echo str_pad($y, 3, " ", STR_PAD_LEFT)." ";
		for ($x=0; $x<$extentX; $x++) {
			$key = $x + ($y << 16);
			if ($MAZE[$key]===true) echo "#";
			elseif ($x===$TARGET[0] && $y===$TARGET[1]) echo "+";
			elseif ($MAZE[$key]===false) echo " ";
			else echo ($MAZE[$key] % 10);
		}
		echo "\n";
	}
	echo "\n";
}


$PATH_ENDS = [[1,1]];
$MAZE[1 + (1<<16)] = 0;
$CURRENT_DEPTH = 0;
$LOCATION_COUNT_BY_DEPTH = new ArrayObject();
$LOCATION_COUNT_BY_DEPTH[0] = 1;

while($CURRENT_DEPTH < 100 && count($PATH_ENDS) > 0) {

	$newEnds = [];
	$CURRENT_DEPTH += 1;
	$LOCATION_COUNT_BY_DEPTH[$CURRENT_DEPTH] = $LOCATION_COUNT_BY_DEPTH[$CURRENT_DEPTH-1]; 
	foreach ($PATH_ENDS as $end) {
		$north = [$end[0],   $end[1]-1];
		$east  = [$end[0]+1, $end[1]];
		$south = [$end[0],   $end[1]+1];
		$west  = [$end[0]-1, $end[1]];

		if ($north == $TARGET || 
		    $east  == $TARGET ||
		    $south == $TARGET ||
		    $west  == $TARGET) {
			echo "\n\nHit target at depth $CURRENT_DEPTH \n\n";
			break;
		}

		// $key = $x + ($y << 16);
		$northKey = $north[0] + ($north[1] << 16);
		$eastKey  = $east[0]  + ($east[1] << 16);
		$southKey = $south[0] + ($south[1] << 16);
		$westKey  = $west[0]  + ($west[1] << 16);

		if ($MAZE[$northKey] === false) {
			$MAZE[$northKey] = $CURRENT_DEPTH;
			$newEnds[] = $north;
			$LOCATION_COUNT_BY_DEPTH[$CURRENT_DEPTH] += 1;
		}
		if ($MAZE[$eastKey] === false) {
			$MAZE[$eastKey] = $CURRENT_DEPTH;
			$newEnds[] = $east;
			$LOCATION_COUNT_BY_DEPTH[$CURRENT_DEPTH] += 1;
		}
		if ($MAZE[$southKey] === false) {
			$MAZE[$southKey] = $CURRENT_DEPTH;
			$newEnds[] = $south;
			$LOCATION_COUNT_BY_DEPTH[$CURRENT_DEPTH] += 1;
		}
		if ($MAZE[$westKey] === false) {
			$MAZE[$westKey] = $CURRENT_DEPTH;
			$newEnds[] = $west;
			$LOCATION_COUNT_BY_DEPTH[$CURRENT_DEPTH] += 1;
		}
	}
	$PATH_ENDS = $newEnds;
}
printMaze(50,50);
echo json_encode($LOCATION_COUNT_BY_DEPTH, JSON_PRETTY_PRINT);
echo "\n\n";

