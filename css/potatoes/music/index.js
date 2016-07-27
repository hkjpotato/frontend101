
console.log("hello");

window.addEventListener("click", function() {
setTimeout(function() {
	$("h2>span").addClass("hover");
}, 500);

//2s
setTimeout(function() {
	$(".tips").addClass("hover");
}, 4500);

setTimeout(function() {
	$(".face").addClass("question");
}, 1500);



setTimeout(function() {
	$(".face").addClass("sowhat");
}, 3000);

setTimeout(function() {
	$(".face").addClass("hover");
}, 5600);
});