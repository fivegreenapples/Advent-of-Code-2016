<?php

/*
--- Day 11: Radioisotope Thermoelectric Generators ---

You come upon a column of four floors that have been entirely sealed off from the rest of the building except for a small dedicated lobby. There are some radiation warnings and a big sign which reads "Radioisotope Testing Facility".

According to the project status board, this facility is currently being used to experiment with Radioisotope Thermoelectric Generators (RTGs, or simply "generators") that are designed to be paired with specially-constructed microchips. Basically, an RTG is a highly radioactive rock that generates electricity through heat.

The experimental RTGs have poor radiation containment, so they're dangerously radioactive. The chips are prototypes and don't have normal radiation shielding, but they do have the ability to generate an electromagnetic radiation shield when powered. Unfortunately, they can only be powered by their corresponding RTG. An RTG powering a microchip is still dangerous to other microchips.

In other words, if a chip is ever left in the same area as another RTG, and it's not connected to its own RTG, the chip will be fried. Therefore, it is assumed that you will follow procedure and keep chips connected to their corresponding RTG when they're in the same room, and away from other RTGs otherwise.

These microchips sound very interesting and useful to your current activities, and you'd like to try to retrieve them. The fourth floor of the facility has an assembling machine which can make a self-contained, shielded computer for you to take with you - that is, if you can bring it all of the RTGs and microchips.

Within the radiation-shielded part of the facility (in which it's safe to have these pre-assembly RTGs), there is an elevator that can move between the four floors. Its capacity rating means it can carry at most yourself and two RTGs or microchips in any combination. (They're rigged to some heavy diagnostic equipment - the assembling machine will detach it for you.) As a security measure, the elevator will only function if it contains at least one RTG or microchip. The elevator always stops on each floor to recharge, and this takes long enough that the items within it and the items on that floor can irradiate each other. (You can prevent this if a Microchip and its Generator end up on the same floor in this way, as they can be connected while the elevator is recharging.)

You make some notes of the locations of each component of interest (your puzzle input). Before you don a hazmat suit and start moving things around, you'd like to have an idea of what you need to do.

When you enter the containment area, you and the elevator will start on the first floor.

For example, suppose the isolated area has the following arrangement:

The first floor contains a hydrogen-compatible microchip and a lithium-compatible microchip.
The second floor contains a hydrogen generator.
The third floor contains a lithium generator.
The fourth floor contains nothing relevant.
As a diagram (F# for a Floor number, E for Elevator, H for Hydrogen, L for Lithium, M for Microchip, and G for Generator), the initial state looks like this:

F4 .  .  .  .  .  
F3 .  .  .  LG .  
F2 .  HG .  .  .  
F1 E  .  HM .  LM 
Then, to get everything up to the assembling machine on the fourth floor, the following steps could be taken:

Bring the Hydrogen-compatible Microchip to the second floor, which is safe because it can get power from the Hydrogen Generator:

F4 .  .  .  .  .  
F3 .  .  .  LG .  
F2 E  HG HM .  .  
F1 .  .  .  .  LM 
Bring both Hydrogen-related items to the third floor, which is safe because the Hydrogen-compatible microchip is getting power from its generator:

F4 .  .  .  .  .  
F3 E  HG HM LG .  
F2 .  .  .  .  .  
F1 .  .  .  .  LM 
Leave the Hydrogen Generator on floor three, but bring the Hydrogen-compatible Microchip back down with you so you can still use the elevator:

F4 .  .  .  .  .  
F3 .  HG .  LG .  
F2 E  .  HM .  .  
F1 .  .  .  .  LM 
At the first floor, grab the Lithium-compatible Microchip, which is safe because Microchips don't affect each other:

F4 .  .  .  .  .  
F3 .  HG .  LG .  
F2 .  .  .  .  .  
F1 E  .  HM .  LM 
Bring both Microchips up one floor, where there is nothing to fry them:

F4 .  .  .  .  .  
F3 .  HG .  LG .  
F2 E  .  HM .  LM 
F1 .  .  .  .  .  
Bring both Microchips up again to floor three, where they can be temporarily connected to their corresponding generators while the elevator recharges, preventing either of them from being fried:

F4 .  .  .  .  .  
F3 E  HG HM LG LM 
F2 .  .  .  .  .  
F1 .  .  .  .  .  
Bring both Microchips to the fourth floor:

F4 E  .  HM .  LM 
F3 .  HG .  LG .  
F2 .  .  .  .  .  
F1 .  .  .  .  .  
Leave the Lithium-compatible microchip on the fourth floor, but bring the Hydrogen-compatible one so you can still use the elevator; this is safe because although the Lithium Generator is on the destination floor, you can connect Hydrogen-compatible microchip to the Hydrogen Generator there:

F4 .  .  .  .  LM 
F3 E  HG HM LG .  
F2 .  .  .  .  .  
F1 .  .  .  .  .  
Bring both Generators up to the fourth floor, which is safe because you can connect the Lithium-compatible Microchip to the Lithium Generator upon arrival:

F4 E  HG .  LG LM 
F3 .  .  HM .  .  
F2 .  .  .  .  .  
F1 .  .  .  .  .  
Bring the Lithium Microchip with you to the third floor so you can use the elevator:

F4 .  HG .  LG .  
F3 E  .  HM .  LM 
F2 .  .  .  .  .  
F1 .  .  .  .  .  
Bring both Microchips to the fourth floor:

F4 E  HG HM LG LM 
F3 .  .  .  .  .  
F2 .  .  .  .  .  
F1 .  .  .  .  .  
In this arrangement, it takes 11 steps to collect all of the objects at the fourth floor for assembly. (Each elevator stop counts as one step, even if nothing is added to or removed from it.)

In your situation, what is the minimum number of steps required to bring all of the objects to the fourth floor?

The first floor contains a strontium generator, a strontium-compatible microchip, a plutonium generator, and a plutonium-compatible microchip.
The second floor contains a thulium generator, a ruthenium generator, a ruthenium-compatible microchip, a curium generator, and a curium-compatible microchip.
The third floor contains a thulium-compatible microchip.
The fourth floor contains nothing relevant.


F4   
F3                   TM
F2                TG    RG RM CG CM
F1 E  SG SM PG PM



*/
const GENERATORS = 0;
const MICROCHIPS = 1;

const STRONTIUM = 0x1;
const PLUTONIUM = 0x2;
const THULIUM   = 0x4;
const RUTHENIUM = 0x8;
const CURIUM    = 0x10;


$ALL_METALS = [STRONTIUM,PLUTONIUM,THULIUM,RUTHENIUM,CURIUM];


$INITIAL = [
	"floors" => [
		[
			GENERATORS => STRONTIUM | PLUTONIUM,
			MICROCHIPS => STRONTIUM | PLUTONIUM
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

function hashState(&$state) {
	$hash = "";
	for ($n=0; $n<4; $n++) {
		$hash .= ($state["floors"][$n][GENERATORS] + ($state["floors"][$n][MICROCHIPS] << 8 ));
		$hash .= "-"; 
	}
	$hash .= $state["elevator"];
	return $hash;
}


function processState($state, $depth, &$history) {
	// echo $depth." processState ".$state["hash"]."\n";
	// get the available moves
	global $MOVES, $NEW_FLOORS, $SUCCESS_FLOOR;
	$currentElevator = $state["elevator"];
	$currentG = $state["floors"][$currentElevator][GENERATORS];
	$currentM = $state["floors"][$currentElevator][MICROCHIPS];
	$moves = $MOVES[$currentG][$currentM];

	$resultingStates = [];
	foreach ($moves as $move) {
		// apply a move to the current state
		// we can go up or down in the elevator

		foreach ($NEW_FLOORS[$currentElevator] as $newFloorNumber) {
			$newFloor = [
				GENERATORS => $state["floors"][$newFloorNumber][GENERATORS] | $move["elevator"][GENERATORS],
				MICROCHIPS => $state["floors"][$newFloorNumber][MICROCHIPS] | $move["elevator"][MICROCHIPS]
			];
			if (isSafe($newFloor)) {
				$newState = $state;
				$newState["elevator"] = $newFloorNumber;
				$newState["floors"][$currentElevator] = $move["oldFloor"];
				$newState["floors"][$newFloorNumber] = $newFloor;
				$hash =  ($newState["floors"][0][GENERATORS] + ($newState["floors"][0][MICROCHIPS] << 8 )) +
				         (($newState["floors"][1][GENERATORS] < 16) + ($newState["floors"][1][MICROCHIPS] << 24 ));
				$hash .= "-".(($newState["floors"][2][GENERATORS]) + ($newState["floors"][2][MICROCHIPS] << 8 )) +
				         (($newState["floors"][3][GENERATORS] < 16) + ($newState["floors"][3][MICROCHIPS] << 24 ));
				$hash .= "-".$newState["elevator"];
				// echo $hash."\n";exit();
				// check if we've seen it before
				if (array_key_exists($hash, $history)) {
					// echo "Seen:: ".$hash." at ".$history[$newState["hash"]]."\n";
				}
				else {
					// check if we have finished
					if ($newState["floors"][3][GENERATORS] === $SUCCESS_FLOOR[GENERATORS] &&
						$newState["floors"][3][MICROCHIPS] === $SUCCESS_FLOOR[MICROCHIPS]) {
						throw new Exception("\n\nSuccess with ".$hash." after ".($depth+1)." steps\n\n");
					}
					else {
						// if not seen add it to the history
						$history[$hash] = $depth+1;
						// and store
						$resultingStates[] = $newState;
					}
				}
			}
		}
		
	}

	return $resultingStates;
}

$HISTORY = [];
$HISTORY[hashState($INITIAL)] = 0;

try {
	$statesToProcess = [$INITIAL];
	$depth = 0;
	while($depth < 100) {

		echo "Depth ".$depth.", has ".count($statesToProcess)." states to process\n";

		$newStatesToProcess = [];
		foreach ($statesToProcess as $aState) {
			$newStatesToProcess = array_merge($newStatesToProcess, processState($aState, $depth, $HISTORY));
		}
		$depth += 1;
		$statesToProcess = $newStatesToProcess;
	}
} catch (Exception $e) {
	echo "\n\n\nFinished: ".$e->getMessage()."\n\n";
}

