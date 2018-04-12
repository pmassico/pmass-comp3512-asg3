// source: lab 10 project
function removePreview(e) {
	e.target.classList.remove("gray");
	$("#preview").remove();
}

function movePreview(e)	{
	// position preview based on mouse coordinates
	$("#preview")
	.css("top",	(e.pageY - 300) + "px")
	.css("left", (e.pageX + 30) + "px");
}		

$(function () {
	$('#preview-images img').on('mouseover', function (e) {
		// construct preview filename based on existing img
		var	alt	= $(this).attr('alt');
		var	src	= $(this).attr('src');								
		var	bigsrc = src.replace("square-medium","medium");
		
		// make dynamic element with larger preview image and caption
		var	preview	=	$('<div	id="preview"></div>');
		var	image	=	$('<img	src="'+ bigsrc +'">');
		
		preview.append(image);
		$('body').append(preview);
		
		$(this).addClass("gray");
	    $("#preview").fadeIn(200);
	})
	.on("mouseleave", removePreview)
	.on("mousemove", movePreview);
	
});
