var d = document,
    nativeForm,
    output, result;
// кроссбраузерная установка обработчика событий
function addEvent(elem, type, handler){
  if(elem.addEventListener){
    elem.addEventListener(type, handler, false);
  } else {
    elem.attachEvent('on'+type, handler);
  }
  return false;
}
// create XMLHttpRequest
function getXhrObject(){
  if(typeof XMLHttpRequest === 'undefined'){
    XMLHttpRequest = function() {
      try {
        return new window.ActiveXObject( "Microsoft.XMLHTTP" );
      } catch(e) {}
    };
  }
  return new XMLHttpRequest();
}
// ajax function
function sendAjaxRequest(e){
  var evt = e || window.event;
  // Standart submit form event
  if(evt.preventDefault){
    evt.preventDefault(); 
  } else {
    evt.returnValue = false; // for IE
  }
  // get new xhr object
  var xhr = getXhrObject();
  if(xhr){
    // form data
    var elems = nativeForm.elements, // all elements
        url = nativeForm.action, // action path
        params = [],
        elName,
        elType;
    for(var i = 0; i < elems.length; i++){
      elType = elems[i].type; 
      elName = elems[i].name; 
      if(elName){ 
       params.push(elems[i].name + '=' + elems[i].value);
      }
    }

    xhr.open('POST', url, true); // open connection
    // set headers
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                
    xhr.onreadystatechange = function() { 
      console.log(JSON.stringify(xhr.responseText));
	  if(xhr.readyState == 4 && xhr.status == 200) { // check server response status
        
		var __result = JSON.parse(xhr.responseText);
		
		output.innerHTML = __result.error || __result.site + __result.code; // display result if ok
      }
    }
	output.innerHTML = '<img src="view/images/ajax-loader.gif" style="margin-left: 30px">';
    // starts ajax post request
    xhr.send(params.join('&')); 
  }
  return false;
}

// init function after document loaded
function init(){
  output = d.getElementById('result');
  nativeForm = d.getElementById('nativeForm');
  addEvent(nativeForm, 'submit', sendAjaxRequest);
  return false;
}
// document load event 
addEvent(window, 'load', init);