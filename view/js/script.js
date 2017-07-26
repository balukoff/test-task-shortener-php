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
// Универсальная функция для создания нового объекта XMLHttpRequest
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
// Функция Ajax-запроса
function sendAjaxRequest(e){
  var evt = e || window.event;
  // Отменяем стандартное действие формы по событию submit
  if(evt.preventDefault){
    evt.preventDefault(); // для нормальных браузров
  } else {
    evt.returnValue = false; // для IE старых версий
  }
  // получаем новый XMLHttpRequest-объект
  var xhr = getXhrObject();
  if(xhr){
    // формируем данные формы
    var elems = nativeForm.elements, // все элементы формы
        url = nativeForm.action, // путь к обработчику
        params = [],
        elName,
        elType;
    // проходимся в цикле по всем элементам формы
    for(var i = 0; i < elems.length; i++){
      elType = elems[i].type; // тип текущего элемента (атрибут type)
      elName = elems[i].name; // имя текущего элемента (атрибут name)
      if(elName){ // если атрибут name присутствует
       params.push(elems[i].name + '=' + elems[i].value);
      }
    }

    xhr.open('POST', url, true); // открываем соединение
    // заголовки - для POST-запроса
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                
    xhr.onreadystatechange = function() { 
      console.log(JSON.stringify(xhr.responseText));
	  if(xhr.readyState == 4 && xhr.status == 200) { // проверяем стадию обработки и статус ответа сервера
        
		var __result = JSON.parse(xhr.responseText);
		
		output.innerHTML = __result.error || __result.site + __result.code; // если все хорошо, то выводим полученный ответ
      }
    }
	output.innerHTML = '<img src="view/images/ajax-loader.gif" style="margin-left: 30px">';
    // стартуем ajax-запрос
    xhr.send(params.join('&')); // для GET запроса - xhr.send(null);
  }
  return false;
}

// Инициализация после загрузки документа
function init(){
  output = d.getElementById('result');
  nativeForm = d.getElementById('nativeForm');
  addEvent(nativeForm, 'submit', sendAjaxRequest);
  return false;
}
// Обработчик события загрузки документа
addEvent(window, 'load', init);