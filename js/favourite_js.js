$(function(){
    var printServices = "print-services.php";
    var numFav = document.querySelector('.favTable').childElementCount;
   
   //populate lists
       
       $.get(printServices , function(data, status) {
           
           //populate size list
           var sizeArray = data.sizes;
           
           $.each(sizeArray, function(index, value) {
               var option = $("<option value="+value.id+">"+value.name+"</option>");
               if (value.id==0) {
                   option.attr('selected', 'selected');
               }
               $('.size-list').append(option);
           });
           
            //populate paper list
            var paperArray = data.stock;
           
            $.each(paperArray, function(index, value) {
               var option = $("<option value="+value.id+">"+value.name+"</option>");
               if (value.id==0) {
                   option.attr('selected', 'selected');
               }
               $('.paper-list').append(option);
            });
    
            //populate frame list
            var frameArray = data.frame;
           
            $.each(frameArray, function(index, value) {
               var option = $("<option value="+value.id+">"+value.name+"</option>");
               if (value.id==0) {
                   option.attr('selected', 'selected');
               }
               $('.frame-list').append(option);
            });
            
            //populate shipping options
            var shippingOptions = data.shipping;
            
            $.each(shippingOptions, function(index, value) {
                var radio = $("<input type='radio' name='shippingOption' value="+value.id+" > ");
                console.log(radio);
                var shipName = value.name + " ";
                if (value.id==0) {
                    radio.attr('checked','checked');
               }
                $('#shippingOptions').append(radio);
                $('#shippingOptions').append(shipName);
            });
           
       });
       
       $('#print').on('click' , function () {
            //for each favourite, calculate the line total
            for(let i=0; i<numFav; i++) { calcLineTotal(i+1); }
       });
       
   //if print options changed
   $('.print-select').on('change', function(e){
           var target = e.target;
           var changeNum = parseInt(target.id.charAt(target.id.length-1));
           
           //update line total
           calcLineTotal(changeNum);
           
       });
       
   //if shipping options changed
   $("#shippingOptions").on('click', function(e){
       calcShipping(e.target.value); 
   });
   
   //submit order
   $('#order').on('click', function(){
       var url = "order.php?";
       var num = 0;
       
       for (let i=0; i<numFav; i++) {
        num=num+1;
        
        var imgID = "#printImg"+num ;
        var title = document.querySelector(imgID).alt;
        url = url + "&title" + num + "=" + title;
        
        var sizeID = "#size"+num;
        var size = document.querySelector(sizeID).value;
        url = url + "&size" + num + "=" + size;
        
        var paperID = "#paper"+num;
        var paper = document.querySelector(paperID).value;
        url = url + "&paper" + num + "=" + paper;
        
        var frameID = "#frame"+num;
        var frame = document.querySelector(frameID).value;
        url = url + "&frame" + num + "=" + frame;
        
        var qtyID = "#qty"+num;
        var qty = document.querySelector(qtyID).value;
        url = url + "&qty" + num + "=" + qty;
       }
       
       //get shipping speed
       var ship = document.querySelector('input:checked').value;
       url = url + "&ship=" + ship;
       
       console.log(url);
       
    //   window.location.href = url;
    var form = document.querySelector('#printForm');
    form.action = url;
    form.submit();
    
    
   });
       
    function removePreview(e) {
    	e.target.classList.remove("gray");
	    $("#preview").remove();
    }
    
    function movePreview(e) {
        // position preview based on mouse coordinates
    	$("#preview")
    	.css("top",	(e.pageY - 100) + "px")
    	.css("left", (e.pageX - 170) + "px");
    }
   
    $(function() {
        $('.printImg').on('mouseover', function(e){
            //pop image
            // construct preview filename based on existing img
    		var	alt	=	$(this).attr('alt');
    		var	src	=	$(this).attr('src');								
    		var	bigsrc	=	src.replace("square-small","square-medium");
    		
    		// make dynamic element with larger preview image and caption
    		var	preview	=	$('<div	id="preview"></div>');
    		var	image	=	$('<img	src="'+ bigsrc +'">');
    		
    		$.get(printServices, function(data, status) {
    		    var selected = $("#frame1 option:selected").val();
    		    var frameColor = data.frame[selected].color;
    		    preview.css("background-color", frameColor);
    		});
    		
    		preview.append(image);
    		$('.modal-body').append(preview);
    		
    		$(this).addClass("gray");
    	    $("#preview").fadeIn(200);
        })
        .on("mouseleave", removePreview)
	    .on("mousemove", movePreview);
    }); 
    
    function calcLineTotal(num) {
        
        var sizeID = "#size"+num;
        var size = document.querySelector(sizeID).value;
        
        var paperID = "#paper"+num;
        var paper = document.querySelector(paperID).value;
        
        var frameID = "#frame"+num;
        var frame = document.querySelector(frameID).value;
        
        var qtyID = "#qty"+num;
        var qty = document.querySelector(qtyID).value;
        
        $.get(printServices , function(data, status) {
            var sizeArray = data.sizes;
            var sizeMatch = sizeArray.find ((s) => s.id==size);
            var sizeCost = sizeMatch.cost;
            
            var paperArray = data.stock;
            var paperMatch = paperArray.find ((p) => p.id==paper);
            var paperCost = 0;
            
            if(size==0 || size==1) {
                paperCost = paperMatch.small_cost;
            } else {
                paperCost = paperMatch.large_cost;
            }
            
            var frameArray = data.frame;
            var frameMatch = frameArray.find ((f) => f.id==frame);
            var frameCost = frameMatch.costs[size];
            
            var lineTotalAmt = 0;
            
            if (qty > 0) {
                lineTotalAmt = qty*(sizeCost + paperCost + frameCost);
            } else {
                lineTotalAmt = sizeCost + paperCost + frameCost;
            }
            
            var curLineTotal = $('#lineTotalAmt'+num).text();
            curLineTotal = parseFloat(curLineTotal);
            
            //remove and append so that DOM will be updated
            $('#lineTotalAmt'+num).remove();
            $('#lineTotal'+num).append("<span id='lineTotalAmt"+num+"'>"+lineTotalAmt.toFixed(2)+"</span>");
            
            //update subtotal
            calcSubTotal(lineTotalAmt-curLineTotal);
            
        });
        
        
    }
    
    function calcSubTotal(lineTotalAmt) {
        
        //GET CURRENT SUBTOTAL
        var subtotal = document.querySelector('#subTotalAmt').innerHTML;
        subtotal = parseFloat(subtotal);
        
        //ADD LINETOTALAMT
        subtotal = subtotal + lineTotalAmt;
        
        //remove and append so that DOM will be updated
        $('#subTotalAmt').remove();
        $('#subTotal').append("<span id='subTotalAmt'>"+subtotal.toFixed(2)+"</span>");
        
        //CALCSHIPPING
        calcShipping(document.querySelector('input:checked').value);
    }
    
    function calcShipping(checkedVal) {
        
        // get frame quantity
	    var frameQty = getFrameQty();
	    
	    var shippingCost = 0;
	    
    	if (frameQty == 0) {
    		getShippingCost(checkedVal, "none");
    	} else if (frameQty < 10) {
    		getShippingCost(checkedVal, "under10");
    	} else if (frameQty > 10) {
    		getShippingCost(checkedVal, "over10");
    	}
        
    }
    
    function getShippingCost(checkedVal, numFrame) {
        $.get(printServices, function(data, status) {
            var shipping = data.shipping[checkedVal];
            console.log(shipping);
            
            cost = shipping.rules[numFrame];
            cost = parseFloat(cost);
            
            $('#shippingTotalAmt').remove();
            $('#shippingTotal').append("<span id='shippingTotalAmt'>"+cost.toFixed(2)+"</span>");
            
            //CALCGRANDTOTAL
            calcGrandTotal();
        });
    }

    
    function getFrameQty() {
        numFav = document.querySelector('.favTable').childElementCount;
        var frameQty = 0;
        var num = 0;
        
        for (let i=0; i<numFav; i++) {
            num = num+1;
            
            var frameID = "#frame"+num;
            var frame = document.querySelector(frameID).value;
            
            var qtyID = "#qty"+num;
            var qty = document.querySelector(qtyID).value;
            
            qty = parseInt(qty);
        
            if (frame != 0) {
                frameQty += qty;
            }
        }
    
        return frameQty;
    }
    
    function calcGrandTotal() {
        //GET CURRENT SUBTOTAL
        var subtotal = document.querySelector('#subTotalAmt').innerHTML;
        subtotal = parseFloat(subtotal);
        
        //GET CURRENT SHIPPING COST
        var shiptotal = document.querySelector('#shippingTotalAmt').innerHTML;
        shiptotal = parseFloat(shiptotal);
        
        //ADD LINETOTALAMT
        grandtotal = subtotal + shiptotal;
        
        //remove and append so that DOM will be updated
        $('#grandTotalAmt').remove();
        $('#grandTotal').append("<span id='grandTotalAmt'>"+grandtotal.toFixed(2)+"</span>");
    }
    
    
});