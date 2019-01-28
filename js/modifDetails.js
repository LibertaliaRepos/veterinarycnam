                            ///////////////////////////////////////////////          
                            //                                           //
                            //          GESTION DES EVENEMENTS DE        //
                            //            LA GESTION DU SITE             //
                            //                                           //
                            ///////////////////////////////////////////////

//function insertSpaceNumber(event) {
//    // Récupération du code (integer) de la touche tapé
//    var keyCode = event.keyCode;
//    // Vérivie que la touche frappé n'est pas le retour en arrière
//    if (keyCode != 8 && keyCode != 37) {
//        var regex = / /gi;
//        var number = this.value.replace(regex, '');
//        var letterCount = number.length;
//
//        if (letterCount % 2 == 0 && letterCount != 0 && letterCount < 10) {
//            this.value += ' ';
//        }
//    } else {
//        this.value = this.value.trimRight();
//    }
//    
//}

var detailsForm = document.getElementById('detailsForm');

// Vérifi si le formulaire id="deailtsForm" est bien présent.
if (detailsForm != null) {
    
    
    // Elément de type <input type="tel />"
    var inputTel_Elts = document.querySelectorAll('input[type=tel]');
    // Input du code postal
    var postalCode = document.getElementById('postalCodeInp');
    
    // Gestion des événements sur tous les input[type=tel]
    // et pour le code postal
    for (var i = 0; i < inputTel_Elts.length; ++i) {
        // Insertion d'un espace tout les 2 caractères
        // dans les élément input type=tel
        Listener(inputTel_Elts[i], 'keypress', insertSpaceNumber);
        
        
        // Interdiction des caractères autres que des chiffres
        // dans les élément input type=tel
        Listener(inputTel_Elts[i], 'keypress', isInteger);
        // et dans le champ réservé au code postal.
        Listener(postalCode, 'keypress', isInteger);
    }
    
    // Element input[type=file] permettant de choisir la photo de présentation du cabinet
    var detailsinputFile = document.getElementById('pictureInp');
    
    // Affichage d'une preview de l'image choisi
    Listener(detailsinputFile, 'change', srcPreview);
    
    
    
    
    // Création d'un compteur donnant le nombre de caractères qu'il reste à taper.
    var imgDetailsDescr = document.getElementById('descrPictInp');
    inputCharCounter(100, imgDetailsDescr);
    
    // Désactivation du block permettant de modifier l'image
    // quand la checkbox de suppression est cocher.
    function disableImg() {
        // La section à désactiver
        var detailsImgArea = document.getElementById('pictureArea');
        disableArea(detailsImgArea, this);
    }
    
    
    // Checkbox permettant de supprimer l'image de preséentation.
    var delDetailsImg = document.getElementById('deletePicture');
    Listener(delDetailsImg, 'change',disableImg);
}