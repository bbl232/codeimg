//http://stackoverflow.com/questions/11076975/insert-text-into-textarea-at-cursor-position-javascript, thanks to http://stackoverflow.com/users/1398296/alex-lynch and http://stackoverflow.com/users/340140/user340140
function insertAtCursor(myField, myValue) { 
    //IE support
    if (document.selection) {
        myField.focus();
        sel = document.selection.createRange();
        sel.text = myValue;
    }
    //MOZILLA and others
    else if (myField.selectionStart || myField.selectionStart == '0') {
        var startPos = myField.selectionStart;
        var endPos = myField.selectionEnd;
        myField.value = myField.value.substring(0, startPos) + myValue + myField.value.substring(endPos, myField.value.length);
        myField.selectionStart = startPos + myValue.length;
        myField.selectionEnd = startPos + myValue.length;
    } else {
        myField.value += myValue;
    }
}

function keyHandler(e) {
    document.getElementById("message").innerHTML = "";
    var TABKEY = 9;
    if(e.keyCode == TABKEY) {
        insertAtCursor(this, "    ");
        if(e.preventDefault) {
            e.preventDefault();
        }
        return false;
    }
}

function imgify(){
    var req = new XMLHttpRequest();
    var submit = document.getElementById("imgify");
    var message = document.getElementById("message");
    var code = document.getElementById("code");
    var tags = document.getElementById("tags");
    var name = document.getElementById("name");
    var notes = document.getElementById("notes");
    var id = document.getElementById("id");
    
    if (code.value == ""){
        message.innerHTML = "<div class='alert alert-danger'>Enter some code first!</div>";
        return;
    }
    if (name.value == ""){
        message.innerHTML = "<div class='alert alert-danger'>You must give your code a name!</div>";
        return;
    }

    var postData = "code="+encodeURIComponent(code.value)+"&tags="+encodeURIComponent(tags.value)+"&name="+encodeURIComponent(name.value);
  
    if(notes.value != ''){
      postData += "&notes="+encodeURIComponent(notes.value);
    }
    if(id!=null && id.value != ''){
      postData += "&id="+encodeURIComponent(id.value);
    }

    code.disabled=true;
    tags.disabled=true;
    name.disabled=true;
    submit.disabled=true;
    notes.disabled=true;

    req.onreadystatechange = function(){
        if(req.readyState == 4){
            response = JSON.parse(req.responseText);
            if(response.status=="error"){
                message.innerHTML = "<div class='alert alert-danger'>"+response.message+"</div>";
            }
            else if(response.status=="success"){
                message.innerHTML = "<img src='"+response.image_data+"'>";
            }
            submit.disabled = false;
            code.disabled = false;
            tags.disabled = false;
            name.disabled=false;
            notes.disabled=false;
        }
    }


    req.open("POST","/codeimg/api/image/transform");
    req.setRequestHeader("Content-type","application/x-www-form-urlencoded");

    req.send(postData);
}

var myInput = document.getElementById("code");
if(myInput){
  if(myInput.addEventListener ) {
      myInput.addEventListener('keydown',this.keyHandler,false);
  } else if(myInput.attachEvent ) {
      myInput.attachEvent('onkeydown',this.keyHandler); /* damn IE hack */
  }
}
