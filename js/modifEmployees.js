                            ///////////////////////////////////////////////          
                            //                                           //
                            //          GESTION DES EVENEMENTS DE        //
                            //            LA GESTION DES EMPLOYE         //
                            //                                           //
                            ///////////////////////////////////////////////



var employeeModif = document.getElementById('disablablePict');
if (employeeModif) {
    // Désactivation du block permettant de modifier l'image
    // quand la checkbox de suppression est cocher.

    function disableImg() {
        // La section à désactiver
        var detailsImgArea = document.querySelector('#pictureArea div');
        disableArea(detailsImgArea, this);
    }
    
    // Checkbox permettant de supprimer l'image de presentation.
    var delEmployImg = document.getElementById('delPhoto');
    Listener(delEmployImg, 'change', disableImg);
    
    var employeInpFile = document.getElementById('photoEmployInp');
    Listener(employeInpFile, 'change', srcPreview);
    
    initFroala(300);
}