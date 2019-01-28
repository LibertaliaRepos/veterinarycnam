                            ///////////////////////////////////////////////          
                            //                                           //
                            //          GESTION DES EVENEMENTS DE        //
                            //     POUR LA REDIRECTION DU MENU CONCEILS  //
                            //                                           //
                            ///////////////////////////////////////////////

/**
 * Fonction de redirection.
 * @returns
 */
function goTo() {
	// Récupération de l'url de la page actuel.
    var windowLoc = window.location.href;
    // Expression réguliaire qui récupere le text qu'il y a
    // depuis la racine /php/
    var regex = /(\/php\/)(.*)/;
    
    // Récuperation de la valeur de l'attribu cite du <blockquote> 
    var cite = this.getAttribute('cite').replace('..', '');
    
    // Génération de l'url absolu qui redirigera vers la page demandée
    windowLoc = windowLoc.replace(regex, cite);
    
    // Redirection vers la page demandée
    window.location = windowLoc;
    
    return;
}

// éléments sur lequel on simule un lien.
var consiels = document.querySelector('article.advices');

// Ecouteur qui redirige vers la page demander quand on click sur l'élément.
if (consiels) {
    var blockquote_Elts = document.getElementsByTagName('blockquote');
    for (var i = 0; i < blockquote_Elts.length; ++i) {
        Listener(blockquote_Elts[i], 'click', goTo);
    }
}
