                            ///////////////////////////////////////////////          
                            //                                           //
                            //          GESTION DES EVENEMENTS DE        //
                            //            LA BOITE DE MESSAGERIE		 //
							//			RECEVANT LES DEMANDES DE RDV	 //
							//											 //
							//			/** UTILISATION DE AJAX **/      //
                            //                                           //
                            ///////////////////////////////////////////////

/**
 * Objet preview représentant le pop-up
 * de confirmation avant l'envoie de l'email.
 */
var preview = {
    toPerson : '',		// La personne à qui est envoyé l'email (label + nom + prénom).
    pet : '',			// L'animal pour lequel est pris le rendez-vous (espece + prénom).
    date : '',	  		// Date du rendez-vous.
    doctor: '',	  		// Nom et prénom du docteur.
    docComment: '',		// Commentaire du docteur.
    
    /**
     * Initionalisation de preview (constructeur)
     * 
     * @param array Informations provenant du formulaire permettant de répondre aux RDV.
     */
    init : function(data) {
        this.setToPerson(data);
        this.setDoctor(data);
        this.setDocComment(data);
        this.setPet(data);
        this.date = data.post.date;
    },
    
    /**
     * Configuration du client
     */
    setToPerson : function(data) {
        var label = null;
        switch (data.current_mail.label) {
            case 'Mrs':      label = 'Monsieur';         break;
            case 'Mlle':     label = 'Mademoiselle';     break;
            
            default:  label = 'Madame';
        }
        
        this.toPerson = label + ' ' + data.current_mail.firstname +' '+ data.current_mail.name;
    },
    
    /**
     * Configuration du docteur
     */
    setDoctor : function(data) {
        this.doctor = 'Docteur '+ data.post.DOCTOR.firstname +' '+ data.post.DOCTOR.name;
    },
    
    /**
     * Configuration des commentaires du docteur
     */
    setDocComment : function(data) {
        this.docComment = (data.post.DOCTOR_REQU != '') ? data.post.DOCTOR_REQU : '<em>pas d\'information de votre part</em>';
    },
    
    /**
     *  Configuration de l'animal
     */
    setPet : function(data) {
        this.pet = data.current_mail.specie +' '+ data.current_mail.pet_name;
    },
        
    /**
     * Construction du pop-up.
     */
    makePreview : function() {
        var preview = document.getElementById('appointmentPreview');
        var data_Elts = preview.getElementsByClassName('data');
//        console.log(data_Elts);
        
        data_Elts[0].textContent = this.toPerson;
        data_Elts[1].textContent = this.pet;
        data_Elts[2].textContent = this.date;
        data_Elts[3].textContent = this.doctor;
        data_Elts[4].innerHTML = this.docComment;
    }
    
};


/**
 * Affiche le contenu du message:
 * 		pour une demande de rendez-vous,
 * 		pour répondre au rendez-vous.
 * 
 * @param event
 * @returns none;
 */
function readApp(event) {
    // Récupération de l'identifient de la demande/réponce de rendez-vous.
    var id_read = this.dataset.id;
    
    // Récupération de la valeur de control permettant d'ajuster l'url de la requete
    // permettant de brancher des écouteurs diférents en fonction du type de message.
    var control = this.dataset.control;
    
    // URL de la requete permettant de lire un message.
    var url = '../php/index.php?EX=userSpace&USER_SPACE=appointment&APPOINTMENT='+ control +'&ID=' + id_read;
    
    // identifiant du block à modifier.
    var id = 'appBoxMailReader';
    
    // Affichage du message sélectionné
    // Branchement différent d'écouteur en fonction du type de message.
    if (control == 'readRequest') {
        // Affiche une demande de rendez-vous.
        changeContent(id, url, '', 'listenRequestReader()');
    } else if (control == 'readAnswer') {
        // Affiche une réponce de rendez-vous.
        changeContent(id, url, '', 'listenAnswReader()');
    } 
    
    // Annulation de l'événement.
    stopEvent(event);
    
    return;
}// readApp(event)

/**
 * Affiche une demande de rendez-vous.
 * 
 * @returns none.
 */
function listenRequestReader() {
    // Formulaire premettant de répondre et de donner un rendez-vous.
    var form = document.getElementById('appResponce');
    
    // Bouton submit du formulaire.
    var submit = document.querySelector('input[type=submit]');
    
    // Bouton permettant de supprimer le message.
//    var deleteBTN = document.getElementById('openDelPopup');
    
    // Initialisation de l'éditeur HTML (hauteur 150px).
    initFroala(150);
    
    // Construction du pop-up permettant de confirmer
    // ou d'annuler l'envoie de l'email (convocation pour le RDV).
    Listener(form, 'submit', appPreviewConstruct);
    
    var openDelPopup = document.getElementById('openDelPopup');
    Listener(openDelPopup, 'click', delPopup);
//    deleteMSG();
        
    return;
}// listenRequestReader()

function listenAnswReader() {
    var openDelPopup = document.getElementById('openDelPopup');
    Listener(openDelPopup, 'click', delPopup);
}

/**
 * Récupération sous form JSON des données du formulaire.
 * Création du pop-up permettant de prévisualiser et 
 * de confimer l'envoie par e-mail avant de l'envoyé.
 * 
 * @param event
 * @returns
 */
function appPreviewConstruct(event) {
    
    // Envoie des données du formulaire
    // et reception des données nécéssaire sous forme de JSON
    var data = actionForm('../php/index.php?EX=userSpace&USER_SPACE=appointment&APPOINTMENT=dataPreview', this);        

    // Création de l'objet preview
    // demandant la confirmation/annulation avant l'envoie de l'email.
    Object.create(preview);
    preview.init(data);
    preview.makePreview();

    // Ouverture du pop up.
    var dataOpen = document.getElementById('dataOpen');
    dataOpen.click();
    
    // Envoie de l'email apres confirmation.
    sendEmail();
    // Annulation de l'événement "submit".
    stopEvent(event);
    
    return;
}// appPreviewConstruct(event)

/**
 * Envoie de l'email.
 * 
 * @returns none.
 */
function sendEmail() {
    // Bouton permettant confirmer l'envoie de l'email.
    var confirm = document.getElementById('confirm');
    
    // Ecouteur sur qui permet l'envoie de l'email apres le click
    confirm.addEventListener('click', function() { 
        
        // Insertion d'une image animé GIF indiquant le chargement pour :
        //  la construction du PDF (convocation),
        //  puis l'envoie de l'email 
        var previewBlock = document.querySelector('#appointmentPreview section');
        document.querySelector('#appointmentPreview h2').textContent = "Emission de l'email";
        document.querySelector('#appointmentPreview section').innerHTML = '<img src="../img/loading.gif" alt="Chargement" />';
        
        // Envoie de l'email
        // Mise à jour de la liste des demandes de rendez-vous 
        // Appel de la fonction emailsent().
        changeContent('mailList', '../php/index.php?EX=userSpace&USER_SPACE=appointment&APPOINTMENT=sendEmail', '', 'emailSent()');

    }, false);

    return;
}// sendEmail()

/**
 * Affiche un message confirmant que l'email à bien été envoyé.
 * 
 * @returns none;
 */
function emailSent() {
    // Insertion d'un message informant au l'utilisateur que l'email à bien été envoyé.
    var previewBlock = document.querySelector('#appointmentPreview section');
    document.querySelector('#appointmentPreview h2').textContent = 'Email envoyé';
    document.querySelector('#appointmentPreview section').innerHTML = '<img src="../img/email-sent.png" alt="Email envoyé" />';
    
    // Création d'un bouton permettant de fermer le pop-up.
    var divConfirm = document.getElementById('confirmSendMail');
    var okiBTN = document.createElement('button');
    
    divConfirm.innerHTML = '';
    
    okiBTN.textContent = 'Oki';
    okiBTN.setAttribute('data-close', '');
    okiBTN.setAttribute('class', 'success button');
    okiBTN.style.margin = 'auto';
    divConfirm.appendChild(okiBTN);
    
    return;
}// emailSent()



function delPopup() {
    var param  = 'ID=' + encodeURIComponent(this.dataset.ident);
    var control = this.dataset.control;
    var url = '../php/index.php?EX=userSpace&USER_SPACE=appointment&APPOINTMENT='+ control;
    
    changeContent(this.dataset.open, url, param, 'deleteMSG()');

    return;
}// delPopup()

/**
 * Demande au serveur de supprimer un message (demande/reponce de rendez-vous).
 * 
 * @returns none;
 */
function deleteMSG() {
    var deleteBTN = document.getElementById('deleteMail');
    deleteBTN.addEventListener('click', function(event) {        
        var id = this.dataset.ident;
        var control = this.dataset.control;
        var url = '../php/index.php?EX=userSpace&USER_SPACE=appointment&APPOINTMENT='+ control +'&ID='+ id;
        
        changeContent('mailList',url, '', 'clearPopups()');
        document.getElementById('appBoxMailReader').innerHTML = '<h2 class="appBox-menu-header bordered">Demande de rendez-vous :</h2>';
    }, false);

    return;
}// deleteMSG()

function clearPopups() {
    var overlay = document.getElementsByClassName('reveal-overlay');
    
    for (var i = 0; i < overlay.length; ++i) {
        overlay[i].childNodes[0].innerHTML = '';
    }
}


var jajLink_elts = document.getElementsByClassName('jaj');
var li_elts = document.querySelectorAll('#appBoxMailList li');


/**
 * Assigne la class "current" au message selectionné
 * 
 * @param elem message sélectionné
 * @returns none.
 */
function currentMail(elem) {
    for (var i = 0; i < li_elts.length; ++i) {
        if (li_elts[i].getAttribute('class')) {
            var globClass = li_elts[i].getAttribute('class');
            li_elts[i].setAttribute('class', globClass.replace(/ current/, ''));
        }
    }
    
    var parent = this.parentNode;
    var beforeClass = parent.getAttribute('class');
    parent.setAttribute('class', beforeClass + ' current');
    
    return;
}// currentMail(elem)



// Affiche le contenu du rendez-vous
// quand il est sélectionné.
for (var i = 0; i < jajLink_elts.length; ++i) {
    Listener(jajLink_elts[i], 'click', currentMail);
    Listener(jajLink_elts[i], 'click', readApp);
}

if (document.getElementById('descriptionArea')) {initFroala(300);}

