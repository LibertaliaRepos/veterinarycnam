// variable qui active le debuggage.
var DEBUG_AJAX = false;

/**
 * Créer une connection avec le serveur
 * 
 * @returns object XMLHttpRequest pour les navigateur autre que IE
 * @returns obect ActiveXObject pour IE
 */
function getXhr() {
    var xhr;
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        try {
          xhr = new ActiveXObject("Msxml2.XMLHTTP"); // IE version > 5
        } catch (e) {
          xhr = new ActiveXObject("Microsoft.XMLHTTP");
        }
    } else {
        alert("Votre navigateur ne supporte pas les objets XMLHttpRequest !");
        xhr = false;
    }
    
    return xhr;
}

/**
 * Modification du contenu d'un élément en mode asynchrone
 * @param string identifiant de l'élément à modifier
 * @param string programme de modification
 * @param string paramètres de modification
 * @param string programme d'appel après la modification
 *  
 * @return none
 */
function changeContent(id, url, param, callback) {
    var c = document.getElementById(id);
    c.innerHTML = '<img src="../img/loading.gif" alt="Chargement" />';
    
    var xhr = getXhr();
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send(param);
    
    xhr.onreadystatechange = function() {
        if (xhr.status === 200 && xhr.readyState == 4) {
            c.innerHTML = xhr.responseText;
            
            if (DEBUG_AJAX) {alert(xhr.responseText);}
            if (callback != null) {window.eval(callback);}
            
            var allscript = c.getElementsByTagName('script');
            for (var i = 0; i < allscript.length; ++i) {
                window.eval(allscript[i].text);
            }
        }
    };
    
    return;
}


function actionForm(url, form) {
    var xhr = getXhr();
    xhr.open('POST', url, false);
    
    var data = new FormData(form);
    
    xhr.send(data);
    
    if (DEBUG_AJAX) {alert(xhr.responseText);}
    
    return JSON.parse(xhr.responseText);
}

function actionParam(url, param) {
    var xhr = getXhr();
    xhr.open('POST', url, false);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send(param);
    
    if (DEBUG_AJAX) {alert(xhr.responseText);}
    
    return JSON.parse(xhr.responseText);
}

function testMailIsExists() {
    var param = 'EMAIL=' + encodeURIComponent(this.value);

    var url = '../php/index.php?EX=AJAX_valideMail';
    var parentForm = document.getElementById(this.dataset.parentform);
    
    var emailInvalid = document.getElementById('emailInvalid');
    var emailIsExists = document.getElementById('emailIsExists');
    

    if (this.value.length > 0) {
        var data = actionParam(url, param);

        if (!data) {
            if (emailInvalid == null) {
                var notAvailable = Object.create(helpText);
                notAvailable.init('Votre email n\'est pas valide. Exemple: mon.email@domaine.com');
                notAvailable.setId('emailInvalid');
                this.insertAdjacentHTML('afterend', notAvailable.toString());
            }
            
        } else {
            url = '../php/index.php?EX=userSpace&USER_SPACE=AJAX_checkMail';
            data = actionParam(url, param);
            data = (data[0] > 0) ? false : true;
            
            if (!data) {
                if (emailIsExists == null) {
                    var isExists = Object.create(helpText);
                    isExists.init('Ce compte existe déjas');
                    isExists.setId('emailIsExists');
                    this.insertAdjacentHTML('afterend', isExists.toString());
                }
            }   
        }
        
        if (data) {
            if (emailInvalid != null) {
                emailInvalid.parentNode.removeChild(emailInvalid);
            }
            if (emailIsExists != null) {
                emailIsExists.parentNode.removeChild(emailIsExists);
            }
        } else {
            Listener(parentForm, 'submit', stopEvent);
        }
    }
}