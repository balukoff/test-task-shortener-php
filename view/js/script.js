var d = document,
    nativeForm,
    output, result;
// ��������������� ��������� ����������� �������
function addEvent(elem, type, handler){
  if(elem.addEventListener){
    elem.addEventListener(type, handler, false);
  } else {
    elem.attachEvent('on'+type, handler);
  }
  return false;
}
// ������������� ������� ��� �������� ������ ������� XMLHttpRequest
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
// ������� Ajax-�������
function sendAjaxRequest(e){
  var evt = e || window.event;
  // �������� ����������� �������� ����� �� ������� submit
  if(evt.preventDefault){
    evt.preventDefault(); // ��� ���������� ��������
  } else {
    evt.returnValue = false; // ��� IE ������ ������
  }
  // �������� ����� XMLHttpRequest-������
  var xhr = getXhrObject();
  if(xhr){
    // ��������� ������ �����
    var elems = nativeForm.elements, // ��� �������� �����
        url = nativeForm.action, // ���� � �����������
        params = [],
        elName,
        elType;
    // ���������� � ����� �� ���� ��������� �����
    for(var i = 0; i < elems.length; i++){
      elType = elems[i].type; // ��� �������� �������� (������� type)
      elName = elems[i].name; // ��� �������� �������� (������� name)
      if(elName){ // ���� ������� name ������������
       params.push(elems[i].name + '=' + elems[i].value);
      }
    }

    xhr.open('POST', url, true); // ��������� ����������
    // ��������� - ��� POST-�������
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                
    xhr.onreadystatechange = function() { 
      console.log(JSON.stringify(xhr.responseText));
	  if(xhr.readyState == 4 && xhr.status == 200) { // ��������� ������ ��������� � ������ ������ �������
        
		var __result = JSON.parse(xhr.responseText);
		
		output.innerHTML = __result.error || __result.site + __result.code; // ���� ��� ������, �� ������� ���������� �����
      }
    }
	output.innerHTML = '<img src="view/images/ajax-loader.gif" style="margin-left: 30px">';
    // �������� ajax-������
    xhr.send(params.join('&')); // ��� GET ������� - xhr.send(null);
  }
  return false;
}

// ������������� ����� �������� ���������
function init(){
  output = d.getElementById('result');
  nativeForm = d.getElementById('nativeForm');
  addEvent(nativeForm, 'submit', sendAjaxRequest);
  return false;
}
// ���������� ������� �������� ���������
addEvent(window, 'load', init);