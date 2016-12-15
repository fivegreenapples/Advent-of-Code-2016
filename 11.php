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
const CURIUM    = 0x16;

$INTIAL = [
	"floors" => [
		[
			GENERATORS => STRONTIUM & PLUTONIUM,
			MICROCHIPS => STRONTIUM & PLUTONIUM
		], 
		[
			GENERATORS => THULIUM & RUTHENIUM & CURIUM,
			MICROCHIPS => RUTHENIUM & CURIUM
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
			GENERATORS => STRONTIUM & PLUTONIUM & THULIUM & RUTHENIUM & CURIUM,
			MICROCHIPS => STRONTIUM & PLUTONIUM & THULIUM & RUTHENIUM
		] 
	],
	"elevator" => 2
];


function isSafe($floor) {
	$spareChips = array_diff($floor["chips"], $floor["gennys"]);
	return empty($spareChips) || empty($floor["gennys"]);
}
function isSuccess(&$state) {
	return empty($state["floors"][1]["gennys"]) &&
			empty($state["floors"][2]["gennys"]) &&
			empty($state["floors"][3]["gennys"]) &&
			empty($state["floors"][1]["chips"]) &&
			empty($state["floors"][2]["chips"]) &&
			empty($state["floors"][3]["chips"]);
}


function movesForState(&$state) {

	$elFloor = $state["elevator"];
	$elevatorContents = [];
	$moves = [];

	for ($g=0; $g<count($state["floors"][$elFloor]["gennys"]); $g++) {
		$generator1 = $state["floors"][$elFloor]["gennys"][$g];
		$elevatorContents[] = ["gennys" => [$generator1], "chips" => []];
		for ($gg=$g+1; $gg<count($state["floors"][$elFloor]["gennys"]); $gg++) {
			$generator2 = $state["floors"][$elFloor]["gennys"][$gg];
			$elevatorContents[] = ["gennys" => [$generator1,$generator2], "chips" => []];
		}
		for ($c=0; $c<count($state["floors"][$elFloor]["chips"]); $c++) {
			$chip = $state["floors"][$elFloor]["chips"][$c];
			$elevatorContents[] = ["gennys" => [$generator1], "chips" => [$chip]];
		}
	}
	for ($c=0; $c<count($state["floors"][$elFloor]["chips"]); $c++) {
		$chip1 = $state["floors"][$elFloor]["chips"][$c];
		$elevatorContents[] = ["gennys" => [], "chips" => [$chip1]];
		for ($cc=$c+1; $cc<count($state["floors"][$elFloor]["chips"]); $cc++) {
			$chip2 = $state["floors"][$elFloor]["chips"][$cc];
			$elevatorContents[] = ["gennys" => [], "chips" => [$chip1,$chip2]];
		}
	}
	foreach ($elevatorContents as $i => $contents) {
		if (!isSafe($contents)) {
			continue;
		}
		$newElFloor = [
			"gennys" => array_diff($state["floors"][$elFloor]["gennys"], $contents["gennys"]),
			"chips"  => array_diff($state["floors"][$elFloor]["chips"],  $contents["chips"])
		];
		if (!isSafe($newElFloor)) {
			continue;
		}

		if ($elFloor < 4) {
			$newDestFloor = [
				"gennys" => array_merge($state["floors"][$elFloor+1]["gennys"], $contents["gennys"]),
				"chips"  => array_merge($state["floors"][$elFloor+1]["chips"],  $contents["chips"])
			]; 
			if (!isSafe($newDestFloor)) {
				continue;
			}
			$move = [ "elevator" => $elFloor+1, "floors" => [] ];
			$move["floors"][$elFloor] = $newElFloor;
			$move["floors"][$elFloor+1] = $newDestFloor;
			$moves[] = $move;
		}
		if ($elFloor > 1) {
			$newDestFloor = [
				"gennys" => array_merge($state["floors"][$elFloor-1]["gennys"], $contents["gennys"]),
				"chips"  => array_merge($state["floors"][$elFloor-1]["chips"],  $contents["chips"])
			]; 
			if (!isSafe($newDestFloor)) {
				continue;
			}
			$move = [ "elevator" => $elFloor-1, "floors" => [] ];
			$move["floors"][$elFloor] = $newElFloor;
			$move["floors"][$elFloor-1] = $newDestFloor;
			$moves[] = $move;
		}

	}
	return $moves;
}

function applyMoveToState($state, $move) {
	$state["elevator"] = $move["elevator"];
	foreach($move["floors"] as $floorNum => $floor) {
		$state["floors"][$floorNum] = $floor;
	}
	$state["hash"] = hashState($state);
	return $state;
}

function hashState($state) {
	$state = array_intersect_key($state, ["floors"=>1, "elevator"=>1]);
	sort($state["floors"][1]["gennys"]);
	sort($state["floors"][2]["gennys"]);
	sort($state["floors"][3]["gennys"]);
	sort($state["floors"][4]["gennys"]);
	sort($state["floors"][1]["chips"]);
	sort($state["floors"][2]["chips"]);
	sort($state["floors"][3]["chips"]);
	sort($state["floors"][4]["chips"]);
	return md5(serialize($state));
}


function processState($state, $depth, &$history) {
	// echo $depth." processState ".$state["hash"]."\n";
	// get the available moves
	$moves = movesForState($state);
	// echo count($moves)."\n";
	$resultingStates = [];
	foreach ($moves as $move) {
		// apply a move to the current state
		$newState = applyMoveToState($state, $move);
		// check if we've seen it before
		if (array_key_exists($newState["hash"], $history)) {
			// echo "Seen:: ".$newState["hash"]." at ".$history[$newState["hash"]]."\n";
			continue;
		}
		// check if we have finished
		if (isSuccess($newState)) {
			throw new Exception("\n\nSuccess with ".$newState["hash"]." after ".($depth+1)." steps\n\n");
		}
		// if not seen add it to the history
		$history[$newState["hash"]] = $depth+1;
		// and store
		$resultingStates[] = $newState;
	}

	return $resultingStates;
}

$initialState["hash"] = hashState($initialState);
$history[$initialState["hash"]] = 0;

$statesToProcess = [$initialState];
$depth = 0;
while($depth < 1000) {

	echo "Depth ".$depth.", has ".count($statesToProcess)." states to process\n";

	$newStatesToProcess = [];
	foreach ($statesToProcess as $aState) {
		$newStatesToProcess = array_merge($newStatesToProcess, processState($aState, $depth, $history));
	}
	$depth += 1;
	$statesToProcess = $newStatesToProcess;
}

