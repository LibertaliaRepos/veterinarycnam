/**
 * Initialise l'éditeur HTML FROALA.
 * @returns none
 */
function initFroala(height) {
      $(function() {
        $('#descriptionArea').froalaEditor({
            toolbarButtons: ['bold', 'italic', 'underline', '|', 'color', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', '-', 'insertLink', 'insertImage', '|',  'insertHR', 'selectAll', 'clearFormatting', '|', 'spellChecker', 'help', '|', 'undo', 'redo'],
            htmlRemoveTags: ['script', 'iframe'],
            editorClass: 'cell',
            height: height
        })
  });
      
      return;
}// initFroala()

/**
 * Ajoute à un élément un écouteur en fonction du navigateur.
 * attachEvent pour IE
 * addEventListener pour les autres.
 * 
 * @param elem
 * @param event		
 * @param fnct
 * @returns none;
 */
function Listener(elem, event, fnct) {
    if (elem) {
        //Teste si la fonction addEventListner existe (non IE).
        if (elem.addEventListener) {
            elem.addEventListener(event, fnct, false);
        } else {
            elem.attachEvent('on'+ event, fnct);
        }
        if (event == 'click') {
            elem.style.cursor = 'pointer';
        }
    }
    
    return ;
}// Listener(elem, event, fnct)

/**
 * Fonction d'arrêt de la propagation d'un événement dans la phase de bouillonnement
 * @param event événement
 *
 * return none;
 */
function stopEvent(event) {
    if (event.stopPropagation) {
        event.stopPropagation();
        event.preventDefault();
    } else {
        event.cancelBubble = true;
        event.returnValue = false;
    }
}// stopEvent(event)

function stopListener(elem, event, fnct) {
    if (elem) {
        if (elem.removeEventListener) {
            elem.removeEventListener(event, fnct, false);
        } else {
            elem.detachEvent('on'+ event, fnct);
        }
    }
    
    return;
}

/**
 * Convertion d'un événement clavier en chaîne de caractères
 * @param event événement du clavier
 * 
 * @return string le caractère frappé
 */
function key2char(event) {
    // Boucle sur les propriétés des événements.
    for (var prop in event) {
        // Test si l'événement a la propriété charCode, keycode ou which
        switch(prop) {
            case 'charCode' :   return String.fromCharCode(event.charCode);
            case 'keyCode':     return String.fromCharCode(event.keyCode);
            case 'which':       return String.fromCharCode(event.which);
        }
    }
}// key2char(event)

/**
 * Vérifie que les entrées clavier sont de type entier positif
 * @param event événement du clavier
 *
 * @return boolean true ou false
 */
function isInteger(event) {
    // Expression régulière pour les entiers.
    var valid = /[0-9]/;
    // Expression réguliaire pour les caractères spéciaux
    var special = /[\x00\x0D]/;
    
    // Récupération du caractères frappé
    var car = key2char(event);
    
    //Vérifie si le caractères frappé est un entier ou un décimal
    if ((valid.test(car) || special.test(car))) {
        return true;
    }
    
    //Stop l'événement
    stopEvent(event);
    return false;
}// isInteger(event)

function insertSpaceNumber(event) {
    // Récupération du code (integer) de la touche tapé
    var keyCode = event.keyCode;
    // Vérivie que la touche frappé n'est pas le retour en arrière
    if (keyCode != 8 && keyCode != 37) {
        var regex = / /gi;
        var number = this.value.replace(regex, '');
        var letterCount = number.length;

        if (letterCount % 2 == 0 && letterCount != 0 && letterCount < 10) {
            this.value += ' ';
        }
    } else {
        this.value = this.value.trimRight();
    }
    
}


/**
 * Génère un compteur de caractère pour un input
 * affiche le nombre caractères qu'il reste à taper
 * 
 * @param int maxLetter			La quantité maximal de caractères autorisé
 * @param Element input_Elt		Elemnt input sur lequel on applique le compteur
 * @returns none;
 */
function inputCharCounter(maxLetter, input_Elt) {
//    var inputElt = document.getElementById(inpId);
    var labelElt = document.querySelector('label[for='+ input_Elt.id +']');
    input_Elt.setAttribute('maxlength', maxLetter);
    
    // Création d'un élément span qui contiendra le compteur.
    var counter = document.createElement('span');
    counter.setAttribute('class', 'help-text');
    counter.textContent = 'caractères: '+ maxLetter;
    labelElt.appendChild(counter);
    
    // Affiche le nombre de caractères restant.
    input_Elt.addEventListener('keyup', function() {
        var letterCount = this.value.length;
        counter.innerHTML = '';
        
        counter.textContent = 'caractères: '+ (maxLetter - letterCount);
    }, false);
    
    return;
}// inputCharCounter(maxLetter, input_Elt)

/**
 * Permet de désactiver un block grace à un input[type=checkbox].
 * Si à l'intérieur il y a des input, ils seront disabled quand 
 * le checkbox est cocher
 * 
 * @param disabled_Elt		Element à désactiver
 * @param check_Elt			checkbox qui controle l'evenement.
 * @returns none;
 */
function disableArea(disabled_Elt, check_Elt) {
    var input_Elts = document.querySelectorAll('#'+ disabled_Elt.id +' input');
    var disabled_class = disabled_Elt.getAttribute('class');
    
    if (check_Elt.checked) {
        for (var i = 0; i < input_Elts.length; ++i) {
            input_Elts[i].setAttribute('disabled', 'true');
        }
        disabled_Elt.setAttribute('class', disabled_class + ' disabled');
    } else {
        var regex = / disabled/;
        for (var j = 0; j < input_Elts.length; ++j) {
            input_Elts[j].removeAttribute('disabled');
        }
        disabled_Elt.setAttribute('class', disabled_class.replace(regex, ''));
    }
    
    return;
}// disableArea(disabled_Elt, check_Elt)

function mailTest() {
    // Récupération du formulaire parent.
    var parentForm = document.getElementById(this.dataset.parentform);
    // Récupération des input[type=email]
    var email_Elts = parentForm.querySelectorAll('input[type=email][data-test]');
    
    var mailNotSame = document.getElementById('mailNotSame');
    
    
    console.log(email_Elts);
    
    // Vérification si l'email et sa confirmation sont identiues.
    if (email_Elts[0].value != email_Elts[1].value) {
        // Applation d'un style pour mettre en évidance les champs incorrect.
        for (var i = 0; i < email_Elts.length; ++i) {
            email_Elts[i].style.border = '1px solid red';
            email_Elts[i].style.backgroundColor = '#FAC8C8';
        }
        
        if (mailNotSame == null) {
            // Création de l'Objet helpText
            // qui contient le text d'alerte.
            var help = Object.create(helpText);
            help.init('Les deux adresses ne correspondent pas.');
            help.setId('mailNotSame');

            // Insertion du text d'alerte
            email_Elts[0].insertAdjacentHTML('afterend', help.toString());
        }
        
        // Stop l'événement "submit" tant que les deux emails ne sont pas identiques.
        Listener(parentForm, 'submit', stopEvent);
    } else {
        if (mailNotSame != null) {
            mailNotSame.parentNode.removeChild(mailNotSame);
            for (var i = 0; i < email_Elts.length; ++i) {
                email_Elts[i].removeAttribute('style');
            }
//            parentForm.removeEventListener('submit', stopEvent, false);
            stopListener(parentForm, 'submit', stopEvent);
        }
    }
    
    return;
}// mailTest()

function passwordTest() {
    var parentForm = document.getElementById(this.dataset.parentform);
    
    var pass_Elts = parentForm.querySelectorAll('input[type=password][data-test]');
    
    var passNotSame = document.getElementById('passNotSame');
    
    // Vérification si le mot de passe et sa confirmation sont identiques.
    if (pass_Elts[0].value != pass_Elts[1].value) {
        
        if (passNotSame == null) {
            // Application d'un style pour mettre en évidance les champs incorrect.
            for (var i = 0; i < pass_Elts.length; ++i) {
                pass_Elts[i].style.border = '1px solid red';
                pass_Elts[i].style.backgroundColor = '#FAC8C8';
            }

            // Création de l'Objet helpText
            // qui contient le text d'alerte.
            var help = Object.create(helpText);
            help.init('Les deux mots de passes ne correspondent pas.');
            help.setId('passNotSame');

            // Insertion du text d'alerte
            pass_Elts[0].insertAdjacentHTML('afterend', help.toString());
        }
        // Stop l'événement "submit" tant que les deux emails ne sont pas identiques.
        Listener(parentForm, 'submit', stopEvent);
    } else {
        if (passNotSame != null) {
            passNotSame.parentNode.removeChild(passNotSame);
            for (var i = 0; i < pass_Elts.length; ++i) {
                pass_Elts[i].removeAttribute('style');
            }
//            parentForm.removeEventListener('submit', stopEvent, false);
            stopListener(parentForm, 'submit', stopEvent);
        }
    }
    
    return;
}// passwordTest()

// Initialisation du framework Foundation.
$(document).foundation();

// Initialisation de l'editeur HTML FROALA.
initFroala(300);


var disabledBanLink_Elts = document.getElementsByClassName('disabled-link');
for (var i = 0; i < disabledBanLink_Elts.length; ++i) {
    Listener(disabledBanLink_Elts[i], 'click', stopEvent);
}

