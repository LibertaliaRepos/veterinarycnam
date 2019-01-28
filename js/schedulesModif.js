                            ///////////////////////////////////////////////          
                            //                                           //
                            //          GESTION DES EVENEMENTS DE        //
                            //    LA GESTION DES HORAIRES D'OUVERTURES   //
                            //                                           //
                            ///////////////////////////////////////////////



/**
 * Fonction de qui permet de mettre à jour 
 * l'attribut name des <input> qui sont à l'intérieur des lignes
 * du tableau.
 */
function replaceName(correspondance, p1, p2, p3, p4, chaine) {
    var tr_Elts = document.querySelectorAll('#schedulesForm tbody tr');
    p2 = tr_Elts.length;
    
    return p1 + p2 + p3 + p4;
}


/**
 * Rajoute une ligne supplémentaire au tableau
 * pour permettre l'insertion d'une tranche horaires suplémentaire.
 * Maximum sept tranches horaires (une par jour).
 */
function addSchedRow(event) {
    // Element <tbody> dans lequel on veut rajouter une ligne.
    var tbody = document.querySelector('#schedulesForm tbody');
    
    // Expression réguliaire qui reconnait l'attribu name.
    var regexName = new RegExp(/(name=")(\d)(-)(Lundi|Mardi|Mercredi|Jeudi|Vendredi|Samedi|Dimanche|SCHED")/,'g');
    
    // Expression réguliaire qui reconnait l'attribu checked="true".
    var regexChecked = new RegExp(/(checked)(="true"|)/, 'g');
    
    // Récupération de toutes les lignes du tableau.
    var tr_Elts = document.querySelectorAll('#schedulesForm tbody tr');
    
    // Récupération du code HTML de la dernière ligne.
    var newRow = tr_Elts[(tr_Elts.length -1)].innerHTML;
    
    // Création d'un élément <tr> puis insertion de celui-ci
    // dans le tableau.
    if (tr_Elts.length < 7) {
        var tr = document.createElement('tr');
        var replace = newRow.replace(regexName, replaceName);
        replace = replace.replace(regexChecked, '');
        
        tr.innerHTML = replace;
        tbody.appendChild(tr);
    }
    
    stopEvent(event)
    return;
}



/**
 * Vérifie si l'input[type=checkbox] est cocher ou pas : 
 * 	S'il est cocher les autres checkboxes du meme jour deviennent disabled,
 *  S'il est décocher toutes les checkboxes deviennet utilisable.
 *  De façon a se qu'il n'y ai pas plusieur tranche le meme jour.
 *  
 * @returns
 */
function verifyColCheck() {
    var name = this.getAttribute('name');   // Récupération de l'attribu name de l'émément (input[type=checkbox]).
    var search = name.replace(/\d-/,'');    // Récupération du jour contenu dans l'attribu name.
    
    if (!this.checked) { // si l'élément en cour n'est pas cocher
        // Récupération de tous les élément input[type=checkbox][disabled] correspondant au jour concerné.
        var uncheck = document.querySelectorAll('input[name$='+ search +'][disabled]'); 


        // Suppression de l'attribue disabled pour les rendre utilisable.
        for (var j = 0; j < uncheck.length; ++j) {
            uncheck[j].removeAttribute('disabled');
        }
    } else { // si l'élément en cour est cocher
        // Ajout d'un attribu checked à l'élément en cours.
        this.setAttribute('checked', 'true');
        // Récupération des input[type=checkbox] qui ne sont pas cocher correspondant au jour concerné
        var disabled = document.querySelectorAll('input[name$='+ search +']:not([checked])');
        // Ajout de l'attribu disabled pour les rendre inutilisable.
        for (var k = 0; k < disabled.length; ++k) {
            disabled[k].setAttribute('disabled', 'true');
        }
    }
}// verifyColCheck()

/**
 * Pour chaque ligne vérification qu'il a aumoins un jour cocher par ligne.
 *  Si ce n'est pas le cas, l'input[type=text] correspondant à la tranche horaire
 *  devient disabled.
 * 
 * @returns
 */
function verifyRowCheck() {
    var name = this.getAttribute('name'); 
    var indexLine = name.match(/\d/); // Récupération de l'indice de la ligne.

    // Récupération des l'élément input[type=checkbox] de la ligne concerné.
    var checkLine_elts = document.querySelectorAll('input.line'+ indexLine +'[type=checkbox]');
    // Récupétation de input[type=text] de la ligne concerné dans lequel on renseigne la tranche horaire.
    var schedInput = document.querySelector('input.line'+ indexLine +'[type=text]');


    // Initialisation d'un compteur à 0.
    // Puis incrémentation à chaque intput[type=checkbox] cocher dans la ligne.
    var countCheck = 0;
    for (var i = 0; i < checkLine_elts.length; ++i) {
        if (checkLine_elts[i].checked) {
            ++countCheck;
        }
    }

    // Si le compteur vos 0, l'input[type=text] devient disabled.
    if (countCheck < 1) {
        schedInput.setAttribute('disabled', 'true');
    } else {
        schedInput.removeAttribute('disabled');
    }
    
    return;
}// verifyRowCheck()

// Lien sur lequel on click pour ajouter une nouvelle ligne.
var addGroupLink = document.getElementById('addSchedGroup');
Listener(addGroupLink, 'click', addSchedRow);


var check_elts = document.querySelectorAll('input[type=checkbox]');
for (var i = 0; i < check_elts.length; ++i) {
    Listener(check_elts[i], 'change', verifyColCheck);
    Listener(check_elts[i], 'change', verifyRowCheck);
}
