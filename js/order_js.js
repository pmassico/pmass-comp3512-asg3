$(function(){
    var printServices = "print-services.php";
    
    $.get(printServices , function(data, status) {
        //insert size name
        var tdIDArray = document.querySelectorAll("td");
    
        for (let i=0; i<tdIDArray.length-1; i++) {
            //get id
            var tdID = tdIDArray[i].id;
        
            if(tdID!="") {
                 //split string type and value
                var type = tdID.substring(0,tdID.length-2);
                var val = tdID.substring(tdID.length-2,tdID.length-1);
                var row = tdID.substring(tdID.length-1,tdID.length);
            
                console.log(type);
                console.log(val);
                console.log(row);
                
                var name = "";
                
                //check type 
                if (type=="size") {
                    var sizeArray = data.sizes;
                    var sizeMatch = sizeArray.find ((s) => s.id==val);
                    name = sizeMatch.name;
                } else if (type=="paper") {
                    var paperArray = data.stock;
                    var paperMatch = paperArray.find ((p) => p.id==val);
                    name = paperMatch.name;
                } else if (type=="frame") {
                    var frameArray = data.frame;
                    var frameMatch = frameArray.find ((f) => f.id==val);
                    name = frameMatch.name;
                }
                
                //put name in td
                var select = "#" + tdID;
                document.querySelector(select).append(name);
            }
        }
        
        var shipID = document.querySelector("tfoot tr td:nth-child(2)").id;
        var shipVal = shipID.substring(shipID.length-1,shipID.length);
        console.log(shipVal);
        
        var shipArray = data.shipping;
        var shipMatch = shipArray.find ((s) => s.id==shipVal);
        var shipName = shipMatch.name;
        
        var shipSelect = "#" + shipID;
        document.querySelector(shipSelect).append(shipName);
    });
    
});