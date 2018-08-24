jQuery( document ).ready(function() {

    jQuery(".static-left-content .facebook").hover (
		function() { jQuery(this).stop().animate({right: "0px"}, {duration:300});}, 
		function() {jQuery(this).stop().animate ({right: "-182px"}, {duration:300});},
		500
	);
    jQuery(".static-left-content .insta").hover (
		function() { jQuery(this).stop().animate({right: "0px"}, {duration:300});}, 
		function() {jQuery(this).stop().animate ({right: "-182px"}, {duration:300});},
		500
	);
    jQuery(".static-left-content .twitter").hover (
		function() { jQuery(this).stop().animate({right: "0px"}, {duration:300});}, 
		function() {jQuery(this).stop().animate ({right: "-182px"}, {duration:300});},
		500
	);
    jQuery(".static-left-content .dribble").hover (
		function() { jQuery(this).stop().animate({right: "0px"}, {duration:300});}, 
		function() {jQuery(this).stop().animate ({right: "-182px"}, {duration:300});},
		500
	);
    jQuery(".static-left-content .pinterest").hover (
		function() { jQuery(this).stop().animate({right: "0px"}, {duration:300});}, 
		function() {jQuery(this).stop().animate ({right: "-182px"}, {duration:300});},
		500
	);
    jQuery(".static-left-content .google").hover (
		function() { jQuery(this).stop().animate({right: "0px"}, {duration:100});}, 
		function() {jQuery(this).stop().animate ({right: "-182px"}, {duration:100});},
		3001
	);
});