/*
--- Day 5: How About a Nice Game of Chess? ---

You are faced with a security door designed by Easter Bunny engineers that seem to have acquired most of their security knowledge by watching hacking movies.

The eight-character password for the door is generated one character at a time by finding the MD5 hash of some Door ID (your puzzle input) and an increasing integer index (starting with 0).

A hash indicates the next character in the password if its hexadecimal representation starts with five zeroes. If it does, the sixth character in the hash is the next character of the password.

For example, if the Door ID is abc:

The first index which produces a hash that starts with five zeroes is 3231929, which we find by hashing abc3231929; the sixth character of the hash, and thus the first character of the password, is 1.
5017308 produces the next interesting hash, which starts with 000008f82..., so the second character of the password is 8.
The third time a hash starts with five zeroes is for abc5278568, discovering the character f.
In this example, after continuing this search a total of eight times, the password is 18f47a30.

Given the actual Door ID, what is the password?

Your puzzle input is uqwqemis.


*/

const TEST_INPUT = "abc";
const INPUT = "uqwqemis";

function run(doorId) {
	function md5(val) {
		
		if (!("crypto" in window) || !("subtle" in window.crypto)) {
			console.error("This JS implementation doesn't support Subtle Crypto.");
			throw Error("Crypto unsupported");
		}

		function ab2hex (buf) {
			let view = new Uint8Array(buf);
			const hexTab = "0123456789abcdef";
			let hex = "";
			for (let b=0; b<view.length; b++) {
				hex += hexTab.charAt((view[b] >>> 4) & 0x0F) + hexTab.charAt(view[b] & 0x0F);
			}
			return hex;
		}
		function str2ab(str) {
			var buf = new ArrayBuffer(str.length*2); // 2 bytes for each char
			var bufView = new Uint16Array(buf);
			for (var i=0, strLen=str.length; i < strLen; i++) {
				bufView[i] = str.charCodeAt(i);
			}
			return buf;
		}



		return window.crypto.subtle.digest(
			{
				name: "MD5",
			},
			str2ab(val)
		)
		.then(function(hash){
			//returns the hash as an ArrayBuffer
			return ab2hex(hash);
		})
	}


	function tryCode(salt, i) {
		if (i%100000 === 0) {
			console.log("i:"+i);
		}
		return md5(salt+i)
		.then(function(hash){
			if (hash.slice(0, 5) === "00000") {
				return hash.slice(5, 6);
			}
			return tryCode(salt, i+1);
		})
	}


	
	return tryCode(doorId, 0).then(function(character){
		return character;
	})
}

run(TEST_INPUT).then(function(result) {
	console.log("Password is: "+result)
});