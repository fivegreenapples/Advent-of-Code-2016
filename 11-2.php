<?php

/*
--- Part Two ---

You step into the cleanroom separating the lobby from the isolated area and put on the hazmat suit.

Upon entering the isolated containment area, however, you notice some extra parts on the first floor that weren't listed on the record outside:

An elerium generator.
An elerium-compatible microchip.
A dilithium generator.
A dilithium-compatible microchip.
These work just like the other generators and microchips. You'll have to get them up to assembly as well.

What is the minimum number of steps required to bring all of the objects, including these four new ones, to the fourth floor?



*/
ini_set('memory_limit','4096M');
const GENERATORS = 0;
const MICROCHIPS = 1;

const STRONTIUM = 0x1;
const PLUTONIUM = 0x2;
const THULIUM   = 0x4;
const RUTHENIUM = 0x8;
const CURIUM    = 0x10;
const ELERIUM    = 0x20;
const DILITHIUM    = 0x40;


$ALL_METALS = [STRONTIUM,PLUTONIUM,THULIUM,RUTHENIUM,CURIUM,ELERIUM,DILITHIUM];
$ALL_METALS_DISPLAY = [STRONTIUM=>"S",PLUTONIUM=>"P",THULIUM=>"T",RUTHENIUM=>"R",CURIUM=>"C",ELERIUM=>"E",DILITHIUM=>"D"];

$INITIAL = [
	"floors" => [
		[
			GENERATORS => STRONTIUM | PLUTONIUM | ELERIUM | DILITHIUM,
			MICROCHIPS => STRONTIUM | PLUTONIUM | ELERIUM | DILITHIUM
		], 
		[
			GENERATORS => THULIUM | RUTHENIUM | CURIUM,
			MICROCHIPS => RUTHENIUM | CURIUM
		], 
		[
			GENERATORS => 0,
			MICROCHIPS => THULIUM
		], 
		[
			GENERATORS => 0,
			MICROCHIPS => 0
		] 
	],
	"elevator" => 0
];

$TEST_INITIAL = [
	"floors" => [
		[
			GENERATORS => 0,
			MICROCHIPS => 0
		], 
		[
			GENERATORS => 0,
			MICROCHIPS => 0
		], 
		[
			GENERATORS => 0,
			MICROCHIPS => CURIUM
		], 
		[
			GENERATORS => STRONTIUM | PLUTONIUM | THULIUM | RUTHENIUM | CURIUM,
			MICROCHIPS => STRONTIUM | PLUTONIUM | THULIUM | RUTHENIUM
		] 
	],
	"elevator" => 2
];

$SUCCESS_FLOOR = [
	GENERATORS => array_sum($ALL_METALS),
	MICROCHIPS => array_sum($ALL_METALS)
];

function isSafe(&$floor) {

	// safe if no generators
	// or all chips are matched to generators
	return $floor[GENERATORS] === 0 ||
	       ($floor[MICROCHIPS] & ($floor[GENERATORS] ^ $floor[MICROCHIPS])) === 0;

}

function isSuccess(&$state) {
	global $SUCCESS_FLOOR;
	return $state["floors"][3][GENERATORS] === $SUCCESS_FLOOR[GENERATORS] &&
	       $state["floors"][3][MICROCHIPS] === $SUCCESS_FLOOR[MICROCHIPS];
}



// Calculate all possible moves from all possible floor combinations
$maxFloorState = array_sum($ALL_METALS);
$SINGLES_FOR_FLOOR_ITEMS = [];
$DOUBLES_FOR_FLOOR_ITEMS = [];
for ($n=0; $n<=$maxFloorState; $n++) {
	$SINGLES_FOR_FLOOR_ITEMS[$n] = [];
	$DOUBLES_FOR_FLOOR_ITEMS[$n] = [];
	foreach($ALL_METALS as $METAL) {
		if ($n & $METAL) {
			$SINGLES_FOR_FLOOR_ITEMS[$n][] = $METAL;
			foreach($ALL_METALS as $METAL2) {
				if ($METAL !== $METAL2 && $n & $METAL2) {
					$DOUBLES_FOR_FLOOR_ITEMS[$n][] = $METAL | $METAL2;;
				}
			}
		}
	}
	$DOUBLES_FOR_FLOOR_ITEMS[$n] = array_values(array_unique($DOUBLES_FOR_FLOOR_ITEMS[$n]));
}

$MOVES = [];
for ($G=0; $G<=$maxFloorState; $G++) {
	$MOVES[$G] = [];
	for ($M=0; $M<=$maxFloorState; $M++) {

		$MOVES[$G][$M] = [];

		// single and double of the same thing is ok
		$singleGenerators = $SINGLES_FOR_FLOOR_ITEMS[$G];
		$doubleGenerators = $DOUBLES_FOR_FLOOR_ITEMS[$G];
		$singleMicrochips = $SINGLES_FOR_FLOOR_ITEMS[$M];
		$doubleMicrochips = $DOUBLES_FOR_FLOOR_ITEMS[$M];
		// 1 of G and M must be the same metal
		// get singles for the available pairs
		$availablePairs = $SINGLES_FOR_FLOOR_ITEMS[$G & $M];

		// combine everything
		$elevatorOptions = [];
		foreach($singleGenerators as $option) {
			$elevatorOptions[] = [
				GENERATORS => $option, MICROCHIPS => 0
			];
		}
		foreach($doubleGenerators as $option) {
			$elevatorOptions[] = [
				GENERATORS => $option, MICROCHIPS => 0
			];
		}
		foreach($singleMicrochips as $option) {
			$elevatorOptions[] = [
				GENERATORS => 0, MICROCHIPS => $option
			];
		}
		foreach($doubleMicrochips as $option) {
			$elevatorOptions[] = [
				GENERATORS => 0, MICROCHIPS => $option
			];
		}
		foreach($availablePairs as $option) {
			$elevatorOptions[] = [
				GENERATORS => $option, MICROCHIPS => $option
			];
		}
		

		// now apply elevator options to floor state to see if the option is actually isSafe
		// also check that our elevator option is safe and actually exists
		foreach($elevatorOptions as $option) {
			if (!isSafe($option)) throw new Exception("Elevator option not safe! ".json_encode($option));
			if (($option[GENERATORS] & $G) !== $option[GENERATORS]) throw new Exception("Elevator option generators doesn't exist for floor! $G : ".json_encode($option));
			if (($option[MICROCHIPS] & $M) !== $option[MICROCHIPS]) throw new Exception("Elevator option microchips doesn't exist for floor! $M : ".json_encode($option));

			$oldFloor = [
				GENERATORS => $option[GENERATORS] ^ $G,
				MICROCHIPS => $option[MICROCHIPS] ^ $M
			];
			if (!isSafe($oldFloor)) {
				continue;
			}

			$MOVES[$G][$M][] = [
				"elevator"    => $option,
				"oldFloor"    => $oldFloor
			];

		}
		


	}
}

$NEW_FLOORS = [
	0 => [1],
	1 => [0,2],
	2 => [1,3],
	3 => [2],
];

function hashState(&$newState) {
	$hash =  ($newState["floors"][0][GENERATORS] + ($newState["floors"][0][MICROCHIPS] << 8 )) +
				(($newState["floors"][1][GENERATORS] < 16) + ($newState["floors"][1][MICROCHIPS] << 24 ));
	$hash .= "-".(($newState["floors"][2][GENERATORS]) + ($newState["floors"][2][MICROCHIPS] << 8 )) +
				(($newState["floors"][3][GENERATORS] < 16) + ($newState["floors"][3][MICROCHIPS] << 24 ));
	$hash .= "-".$newState["elevator"];
	return $hash;
}


function processState($state, $depth, &$history, &$resultingStates) {
	// get the available moves
	global $MOVES, $NEW_FLOORS, $SUCCESS_FLOOR;
	$currentElevator = $state["elevator"];

	foreach ($MOVES[$state["floors"][$currentElevator][GENERATORS]][$state["floors"][$currentElevator][MICROCHIPS]] as $move) {
		// apply a move to the current state
		// we can go up or down in the elevator

		foreach ($NEW_FLOORS[$currentElevator] as $newFloorNumber) {
			$newFloor = [
				GENERATORS => $state["floors"][$newFloorNumber][GENERATORS] | $move["elevator"][GENERATORS],
				MICROCHIPS => $state["floors"][$newFloorNumber][MICROCHIPS] | $move["elevator"][MICROCHIPS]
			];
			if ($newFloor[GENERATORS] === 0 ||
				($newFloor[MICROCHIPS] & ($newFloor[GENERATORS] ^ $newFloor[MICROCHIPS])) === 0) {

				$newState = $state;
				$newState["elevator"] = $newFloorNumber;
				$newState["floors"][$currentElevator] = $move["oldFloor"];
				$newState["floors"][$newFloorNumber] = $newFloor;
				$hash1 = ($newState["floors"][0][GENERATORS] + ($newState["floors"][0][MICROCHIPS] << 8 )) +
				         (($newState["floors"][1][GENERATORS] << 16) + ($newState["floors"][1][MICROCHIPS] << 24 ));
				$hash2 = (($newState["floors"][2][GENERATORS]) + ($newState["floors"][2][MICROCHIPS] << 8 )) +
				         (($newState["floors"][3][GENERATORS] << 16) + ($newState["floors"][3][MICROCHIPS] << 24 ));
				$hash3 = $newState["elevator"];
				// check if we've seen it before
				if (isset($history[$hash1]) && 
					isset($history[$hash1][$hash2]) &&
					isset($history[$hash1][$hash2][$hash3])) {
				}
				else {
					// check if we have finished
					if ($newState["floors"][3][GENERATORS] === $SUCCESS_FLOOR[GENERATORS] &&
						$newState["floors"][3][MICROCHIPS] === $SUCCESS_FLOOR[MICROCHIPS]) {
						throw new Exception("\n\nSuccess after ".($depth+1)." steps\n\n");
					}
					else {
						// if not seen add it to the history
						$history[$hash1][$hash2][$hash3] = $depth+1;
						// and store
						$resultingStates[] = $newState;
					}
				}
			}
		}
	}

}


$HISTORY = [];
$HISTORY[hashState($INITIAL)] = 0;

try {
	$statesToProcess = [$INITIAL];
	$depth = 0;
	// printState($INITIAL);
	$start = time();
	while($depth < 1000) {

		echo (time() - $start)." Depth ".$depth.", has ".count($statesToProcess)." states to process\n";

		$newStatesToProcess = [];
		foreach ($statesToProcess as $aState) {
			processState($aState, $depth, $HISTORY, $newStatesToProcess);
		}
		$depth += 1;
		// array_map("printState", $newStatesToProcess);
		$statesToProcess = $newStatesToProcess;
	}
} catch (Exception $e) {
	echo "\n\n\nFinished: ".$e->getMessage()."\n\n";
}

function printState($state) {
	global $ALL_METALS_DISPLAY;
	for ($f=3; $f>=0; $f--) {

		echo ($f+1).": ".($state["elevator"]==$f ? "E":" ")." ";
		foreach ($ALL_METALS_DISPLAY as $metal=>$letter) {
			if ($state["floors"][$f][GENERATORS] & $metal) {
				echo $letter."G";
			} else {
				echo "  ";
			}
			echo " ";
			if ($state["floors"][$f][MICROCHIPS] & $metal) {
				echo $letter."M";
			} else {
				echo "  ";
			}
			echo " ";
		} 
		echo "\n";

	} 
	echo "\n";


}

