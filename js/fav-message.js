function getID() {
    
    
}

function getCookies() {
    var cookies = decodeURIComponent(document.cookie);
    cookies = cookies.split(";");
    return cookies;
}

$(function () {
	$('#fav-button').on('click', function(e) {
	    
        var msg = $("#fav-alert");
        
        msg.css("display", "inline");
        msg.css("position", "absolute");
        msg.css("z-index", 100);
        msg.css("margin-top", "36px");
        msg.css("font-family", "Avenir, sans-serif");
        
        // vary message based on added or duplicate
        var cookiesA = getCookies();
        
        var url = document.URL.split("/");
        type = url[4];
        id = url[4].split("=");
        id = id[1];
        console.log(id);
        
        e.preventDefault();
        
        /*
        if (e.target.nodeName == "SPAN") {
            var link = e.target.parentElement.parentElement;
            console.log(link.getAttribute("href"));
            
            // source: https://stackoverflow.com/questions/9877263/time-delayed-redirect
            setTimeout(function () {
               window.location.href = link.getAttribute("href"); 
            }, 2000);
        } else if (e.target.nodeName == "BUTTON") {
            var link = e.target.parentElement;
            
            setTimeout(function () {
               window.location.href = link.getAttribute("href"); 
            }, 2000);
        }
       */
	});
});