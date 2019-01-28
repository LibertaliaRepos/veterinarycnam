function requestPass(event) {
    actionForm('../php/index.php?EX=AJAX_requestPassword', this);
    
    var parent = this.parentNode;
    parent.removeChild(this);
    
    
    var p_Elt = document.createElement('p');
    p_Elt.id = 'passSent';
    p_Elt.setAttribute('class', 'cell medium-6 large-6');
    p_Elt.innerHTML = '<strong>Si l\'email renseigné est valide,vous allez recevoire un email avec vos identifiants de connection.</strong>';
    
    parent.appendChild(p_Elt);
    
    stopEvent(event);
}

function forgotPassListen() {
    var connectForm = document.getElementById('connectForm');
    var forgotPass = document.getElementById('forgotPass');
    var emailInp = document.getElementById('emailForgot');
    
    emailInp.focus();
    connectForm.style.width = '100%';
    Listener(forgotPass, 'submit', requestPass);
    
    $(forgotPass).foundation();
}




var connection = document.getElementById('connection');



if (connection) {
    
    function forgotForm(event) {
        var connectClass = connection.getAttribute('class');
        connection.setAttribute('class', connectClass +' grid-container grid-y grid-margin-y');
        
        var url = '../php/index.php?EX=AJAX_forgotPass';
        changeContent('connection', url, null, 'forgotPassListen()');
        
        
       
        
        stopEvent(event);
    }
    
    
    
    
    var forgotLink = document.getElementById('forgotLink');
    Listener(forgotLink, 'click', forgotForm);
    
}

