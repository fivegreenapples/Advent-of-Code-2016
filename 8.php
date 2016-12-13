<?php
/*
--- Day 8: Two-Factor Authentication ---

You come across a door implementing what you can only assume is an implementation of two-factor authentication after a long game of requirements telephone.

To get past the door, you first swipe a keycard (no problem; there was one on a nearby desk). Then, it displays a code on a little screen, and you type that code on a keypad. Then, presumably, the door unlocks.

Unfortunately, the screen has been smashed. After a few minutes, you've taken everything apart and figured out how it works. Now you just have to work out what the screen would have displayed.

The magnetic strip on the card you swiped encodes a series of instructions for the screen; these instructions are your puzzle input. The screen is 50 pixels wide and 6 pixels tall, all of which start off, and is capable of three somewhat peculiar operations:

rect AxB turns on all of the pixels in a rectangle at the top-left of the screen which is A wide and B tall.
rotate row y=A by B shifts all of the pixels in row A (0 is the top row) right by B pixels. Pixels that would fall off the right end appear at the left end of the row.
rotate column x=A by B shifts all of the pixels in column A (0 is the left column) down by B pixels. Pixels that would fall off the bottom appear at the top of the column.
For example, here is a simple sequence on a smaller screen:

rect 3x2 creates a small rectangle in the top-left corner:

###....
###....
.......
rotate column x=1 by 1 rotates the second column down by one pixel:

#.#....
###....
.#.....
rotate row y=0 by 4 rotates the top row right by four pixels:

....#.#
###....
.#.....
rotate column x=1 by 1 again rotates the second column down by one pixel, causing the bottom pixel to wrap back to the top:

.#..#.#
#.#....
.#.....
As you can see, this display technology is extremely powerful, and will soon dominate the tiny-code-displaying-screen market. That's what the advertisement on the back of the display tries to convince you, anyway.

There seems to be an intermediate check of the voltage used by the display: after you swipe your card, if the screen did work, how many pixels should be lit?

--- Part Two ---

You notice that the screen is only capable of displaying capital letters; in the font it uses, each letter is 5 pixels wide and 6 tall.

After you swipe your card, what code is the screen trying to display?

*/

$INPUT = "rect 1x1
rotate row y=0 by 5
rect 1x1
rotate row y=0 by 5
rect 1x1
rotate row y=0 by 3
rect 1x1
rotate row y=0 by 2
rect 1x1
rotate row y=0 by 3
rect 1x1
rotate row y=0 by 2
rect 1x1
rotate row y=0 by 5
rect 1x1
rotate row y=0 by 5
rect 1x1
rotate row y=0 by 3
rect 1x1
rotate row y=0 by 2
rect 1x1
rotate row y=0 by 3
rect 2x1
rotate row y=0 by 2
rect 1x2
rotate row y=1 by 5
rotate row y=0 by 3
rect 1x2
rotate column x=30 by 1
rotate column x=25 by 1
rotate column x=10 by 1
rotate row y=1 by 5
rotate row y=0 by 2
rect 1x2
rotate row y=0 by 5
rotate column x=0 by 1
rect 4x1
rotate row y=2 by 18
rotate row y=0 by 5
rotate column x=0 by 1
rect 3x1
rotate row y=2 by 12
rotate row y=0 by 5
rotate column x=0 by 1
rect 4x1
rotate column x=20 by 1
rotate row y=2 by 5
rotate row y=0 by 5
rotate column x=0 by 1
rect 4x1
rotate row y=2 by 15
rotate row y=0 by 15
rotate column x=10 by 1
rotate column x=5 by 1
rotate column x=0 by 1
rect 14x1
rotate column x=37 by 1
rotate column x=23 by 1
rotate column x=7 by 2
rotate row y=3 by 20
rotate row y=0 by 5
rotate column x=0 by 1
rect 4x1
rotate row y=3 by 5
rotate row y=2 by 2
rotate row y=1 by 4
rotate row y=0 by 4
rect 1x4
rotate column x=35 by 3
rotate column x=18 by 3
rotate column x=13 by 3
rotate row y=3 by 5
rotate row y=2 by 3
rotate row y=1 by 1
rotate row y=0 by 1
rect 1x5
rotate row y=4 by 20
rotate row y=3 by 10
rotate row y=2 by 13
rotate row y=0 by 10
rotate column x=5 by 1
rotate column x=3 by 3
rotate column x=2 by 1
rotate column x=1 by 1
rotate column x=0 by 1
rect 9x1
rotate row y=4 by 10
rotate row y=3 by 10
rotate row y=1 by 10
rotate row y=0 by 10
rotate column x=7 by 2
rotate column x=5 by 1
rotate column x=2 by 1
rotate column x=1 by 1
rotate column x=0 by 1
rect 9x1
rotate row y=4 by 20
rotate row y=3 by 12
rotate row y=1 by 15
rotate row y=0 by 10
rotate column x=8 by 2
rotate column x=7 by 1
rotate column x=6 by 2
rotate column x=5 by 1
rotate column x=3 by 1
rotate column x=2 by 1
rotate column x=1 by 1
rotate column x=0 by 1
rect 9x1
rotate column x=46 by 2
rotate column x=43 by 2
rotate column x=24 by 2
rotate column x=14 by 3
rotate row y=5 by 15
rotate row y=4 by 10
rotate row y=3 by 3
rotate row y=2 by 37
rotate row y=1 by 10
rotate row y=0 by 5
rotate column x=0 by 3
rect 3x3
rotate row y=5 by 15
rotate row y=3 by 10
rotate row y=2 by 10
rotate row y=0 by 10
rotate column x=7 by 3
rotate column x=6 by 3
rotate column x=5 by 1
rotate column x=3 by 1
rotate column x=2 by 1
rotate column x=1 by 1
rotate column x=0 by 1
rect 9x1
rotate column x=19 by 1
rotate column x=10 by 3
rotate column x=5 by 4
rotate row y=5 by 5
rotate row y=4 by 5
rotate row y=3 by 40
rotate row y=2 by 35
rotate row y=1 by 15
rotate row y=0 by 30
rotate column x=48 by 4
rotate column x=47 by 3
rotate column x=46 by 3
rotate column x=45 by 1
rotate column x=43 by 1
rotate column x=42 by 5
rotate column x=41 by 5
rotate column x=40 by 1
rotate column x=33 by 2
rotate column x=32 by 3
rotate column x=31 by 2
rotate column x=28 by 1
rotate column x=27 by 5
rotate column x=26 by 5
rotate column x=25 by 1
rotate column x=23 by 5
rotate column x=22 by 5
rotate column x=21 by 5
rotate column x=18 by 5
rotate column x=17 by 5
rotate column x=16 by 5
rotate column x=13 by 5
rotate column x=12 by 5
rotate column x=11 by 5
rotate column x=3 by 1
rotate column x=2 by 5
rotate column x=1 by 5
rotate column x=0 by 1";
$WIDTH = 50;
$HEIGHT = 6;
$TEST_INPUT = "rect 3x2
rotate column x=1 by 1
rotate row y=0 by 4
rotate column x=1 by 1";
$TEST_WIDTH = 7;
$TEST_HEIGHT = 3;


function show(&$scr) {
    foreach($scr as $row) {
        foreach($row as $cell) {
            if ($cell) echo "#";
            else echo " ";
        }
        echo "\n";
    }    
    echo "\n";
}
function countOn(&$scr) {
    $count = 0;
    foreach($scr as $row) {
        foreach($row as $cell) {
            if ($cell) $count++;
        }
    }
    return $count;    
}

function drawRect(&$screen, $w, $h) {
    echo "drawRect $w $h\n";
    for($hh=0; $hh<$h; $hh++) {
        for($ww=0; $ww<$w; $ww++) {
            $screen[$hh][$ww] = true;
        }
    }
}
function rotateCol(&$screen, $col, $num) {
    echo "rotateCol $col $num\n";
    while($num--) {

        $c = [];
        for ($hh=0; $hh<count($screen); $hh++) {
            $c[] = $screen[$hh][$col];
        }

        array_unshift($c, $c[count($c)-1]);
        array_pop($c);

        for ($hh=0; $hh<count($screen); $hh++) {
            $screen[$hh][$col] = $c[$hh];
        }

    }

}
function rotateRow(&$screen, $row, $num) {
    echo "rotateRow $row $num\n";
    while($num--) {

        $r = $screen[$row];
        array_unshift($r, $r[count($r)-1]);
        array_pop($r);
        $screen[$row] = $r; 

    }
}
function run($instructions, $w, $h) {

    $instructions = array_map("trim", explode("\n", trim($instructions)));
    $screen = [];
    for($hh=0; $hh<$h; $hh++) {
        $screen[] = [];
        for($ww=0; $ww<$w; $ww++) {
            $screen[$hh][] = false;
        }
    }

    show($screen);

    foreach($instructions as $instruct) {

        if (preg_match("/^rect ([0-9]+)x([0-9]+)$/", $instruct, $matches)) {
            $width = $matches[1];
            $height = $matches[2];
            drawRect($screen, $width, $height);
        } elseif (preg_match("/^rotate row y=([0-9]+) by ([0-9]+)$/", $instruct, $matches)) {
            $row = $matches[1];
            $num = $matches[2];
            rotateRow($screen, $row, $num);
        } elseif (preg_match("/^rotate column x=([0-9]+) by ([0-9]+)$/", $instruct, $matches)) {
            $col = $matches[1];
            $num = $matches[2];
            rotateCol($screen, $col, $num);
        } else {
            die ("\n\nUnhandled instruction: ".$instruct."\n\n");
        } 
        show($screen);

    }

    echo "\n\nNumber of 'on' pixels is: ".countOn($screen)."\n\n";


}

run($INPUT, $WIDTH, $HEIGHT);
// run($TEST_INPUT, $TEST_WIDTH, $TEST_HEIGHT);
