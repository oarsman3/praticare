			
function createXMLHTTPinstance () {
	
	var httpRequest;
	
	if (window.XMLHttpRequest) { // Mozilla, Safari, ...
		httpRequest = new XMLHttpRequest();
	}
	else if (window.ActiveXObject) { // IE
		try {
      		httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
     		} 
     		catch (e) {
  	    		try {
      	  		httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
      			} 
      			catch (e) {
      			}
    		}
    	}
	return httpRequest;
	}
