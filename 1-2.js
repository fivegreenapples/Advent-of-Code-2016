/*

--- Part Two ---

Then, you notice the instructions continue on the back of the Recruiting Document. Easter Bunny HQ is actually at the first location you visit twice.

For example, if your instructions are R8, R4, R4, R8, the first location you visit twice is 4 blocks away, due East.

How many blocks away is the first location you visit twice?

*/


(function() {

	"use strict"

	const INPUT = "L2, L3, L3, L4, R1, R2, L3, R3, R3, L1, L3, R2, R3, L3, R4, R3, R3, L1, L4, R4, L2, R5, R1, L5, R1, R3, L5, R2, L2, R2, R1, L1, L3, L3, R4, R5, R4, L1, L189, L2, R2, L5, R5, R45, L3, R4, R77, L1, R1, R194, R2, L5, L3, L2, L1, R5, L3, L3, L5, L5, L5, R2, L1, L2, L3, R2, R5, R4, L2, R3, R5, L2, L2, R3, L3, L2, L1, L3, R5, R4, R3, R2, L1, R2, L5, R4, L5, L4, R4, L2, R5, L3, L2, R4, L1, L2, R2, R3, L2, L5, R1, R1, R3, R4, R1, R2, R4, R5, L3, L5, L3, L3, R5, R4, R1, L3, R1, L3, R3, R3, R3, L1, R3, R4, L5, L3, L1, L5, L4, R4, R1, L4, R3, R3, R5, R4, R3, R3, L1, L2, R1, L4, L4, L3, L4, L3, L5, R2, R4, L2"


	const DIRECTIONS = ["N", "E", "S", "W"]
	let TURN = {
		L: current => (current + 4 - 1) % 4,
		R: current => (current + 1) % 4 
	}
	let MOVE = (currentDirection, length, easting, northing, markFunc) => {
		let bNotSeen = true;
		while (bNotSeen && length--) {
			switch(DIRECTIONS[currentDirection]) {
				case "N":
					northing += 1;
					break;
				case "E":
					easting += 1;
					break;
				case "S":
					northing -= 1;
					break;
				case "W":
					easting -= 1;
					break;
			}
			bNotSeen = markFunc(easting, northing)
		}
		return [easting, northing, !bNotSeen];
	} 

	let currentDirection = 0; 
	let currentEasting = 0, currentNorthing = 0;
	// grid definition
	// 2 dimensional array; eastings then northings
	// arbitrary offset of 1,000,000 for each so we don't worry about negatives
	let grid = {}; 
	let MARK_GRID = (easting, northing) => {
		easting += 1000000;
		northing += 1000000;
		if (grid[easting] && grid[easting][northing]) return false
		if (!grid[easting]) {
			grid[easting] = {}
		}
		grid[easting][northing] = true;
		return true;
	}


	let bBreak = false; 
	console.log("Facing "+DIRECTIONS[currentDirection]+" at: "+currentEasting+","+currentNorthing);
	INPUT.split(' ').forEach( instruction => {
		if (bBreak) return;

		let turn = instruction.charAt(0)
		let count = parseInt(instruction.substr(1), 10)

		currentDirection = TURN[turn](currentDirection);
		[currentEasting, currentNorthing, bBreak] = MOVE(currentDirection, count, currentEasting, currentNorthing, MARK_GRID)
		console.log(instruction+": Facing "+DIRECTIONS[currentDirection]+" at: "+currentEasting+","+currentNorthing)
	})

	console.log("**");
	console.log("Now we are "+(Math.abs(currentEasting)+Math.abs(currentNorthing))+" away");
	console.log("**");

})()