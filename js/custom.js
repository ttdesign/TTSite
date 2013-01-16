//preloader functions
var images = new Array()

function preload() {
	for (i = 0; i < preload.arguments.length; i++) {
		images[i] = new Image()
		images[i].src = preload.arguments[i]
	}
}

function addLoadEvent(func) {
	var oldonload = window.onload;
	if (typeof window.onload != 'function') {
		window.onload = func;
	} else {
		window.onload = function() {
			if (oldonload) {
				oldonload();
			}
			func();
		}
	}
}

//email for jquery stuff
$(document).ready(function() {

    $(function() { 
		//remove JSdisabled field in form - JS works!
		$('#jsdisabledval').remove();

	  	$("#msgbutt").click(function() {  
	  		//Note: make sure the POST fields in this string match what the PHP expects!
			//get the values from the input elements
			var name = $('#name').val();
			var email = $('#email').val();
			var msg = $('#msginput').val();

		    //validate the contents of the fields
	        if (name === "" || email === "" || msg === "") {  
	        	$('#message').html("<h3>Please fill out all of the form.  We want to hear from you!</h3>");
		        return false;  
	        }  

	    	var dataString = 'name='+ name + '&email=' + email + '&msginput=' + msg;  
		    
	    	//validate the fields

		    $.ajax({  
				type: "POST",  
				//change this to the proper file name
				url: "email_submit.php",  
				data: dataString,  

				//insert the code to deal with the 'success message' 
				success: function(data) {

					//get the response from the php
					var msg = $.trim(data);

					//all this only if the php returns 'success'!
					if(msg === "<h2>Contact Form Submitted!</h2><p>We will be in touch soon.</p>") {
						//remove the submit button
						$('#msgbutt').remove();
						//replace 'Message' with "Thanks!" and adjust 'margin-top' for the input box
						$('#contactplate-3').html('<span class="bodytext">Thanks!</span>');
						//string for #message
						msg = "<h2>Contact Form Submitted!</h2><p>We will be in touch soon.</p>";
					}

					//write response to the message div
					$('#inputbox').html(msg)	
						//fade it in
						.hide()
						.fadeIn(1500);
				}  
	    	});  
	   		return false;   
      	});  //click	      	
    }); //initialization function 
}); //ready

//nivo slider
$(window).load(function() {
    $('#slider').nivoSlider({ controlNav:false, directionNav:true, directionNavHide:false, borderRadius: 500 });
});