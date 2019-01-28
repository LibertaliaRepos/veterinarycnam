<?php
class VDetails {

    /**
     * Constructeur de VBanner
     */
    public function __construct() {}
    
    /**
     * Destructeur de VBanner
     */
    public function __destruct() {}
    
    public function showDetailsForm($_data) {
        echo <<<HERE
<nav class="cell ariane">
    <ul class="breadcrumbs">
        <li><a href="../php/">Accueil</a></li>
        <li>Espace employé</li>
        <li>Gestion du site</li>
        <li><span class="show-for-sr">Current: </span>Modification des coordonnées du cabinet</li>
    </ul>
</nav>
<article id="grid-x-one" class="grid-x grid-margin-x">
        <h1 class="cell">Modifier les coordonées de la clinique</h1>
        
        <form id="detailsForm" class="large-8 large-offset-2 grid-container" action="../php/index.php?EX=userSpace&USER_SPACE=updateDetails" method="post" enctype="multipart/form-data">
            <fieldset class="grid-x grid-margin-x">
            	<legend class="cell">Adresse</legend>
                <p id="requiredHelp" class="cell help-text"><sup>*</sup> : champ obligatoire</p>
                
                <label for="streetInp" class="cell" aria-describedby="requiredHelp"><sup>*</sup> N°, voie :</label>
                    <input id="streetInp" class="cell large-10 medium-10" type="text" name="STREET" value="{$_data['street']}" required />
                <div class="cell large-4 medium-4">
                    <label for="postalCodeInp" aria-describedby="requiredHelp"><sup>*</sup> Code postal :</label>
                        <input id="postalCodeInp" type="text" name="POSTAL_CODE" maxlength="5" value="{$_data['postal_code']}" required />
                </div>
                <div class="cell large-8 medium-8">
                    <label for="cityInp" aria-describedby="requiredHelp"><sup>*</sup> Localitée :</label>
                        <input id="cityInp" type="text" name="CITY" value="{$_data['city']}" required />
                </div>
            </fieldset>
            <fieldset class="grid-x grid-margin-x">
                <legend class="cell">Contacts : téléphone / fax / Urgences</legend>
                
                <label for="phoneInp" class="cell large-4 medium-4 large-offset-1 medium-offset-1" aria-describedby="requiredHelp"><sup>*</sup> Numéro de téléphone :</label>
                    <input id="phoneInp" class="cell large-4 medium-4 large-offset-1 medium-offset-1" type="tel" name="PHONE" maxlength="14" value="{$_data['phone']}" required />
                
                <label for="faxInp" class="cell large-4 medium-4 large-offset-1 medium-offset-1">Numéro de fax :</label>
                    <input id="faxInp" class="cell large-4 medium-4 large-offset-1 medium-offset-1" type="tel" name="FAX" maxlength="14" value="{$_data['fax']}" />
                
                <label for="emergencyInp" class="cell large-4 medium-4 large-offset-1 medium-offset-1" aria-describedby="requiredHelp"><sup>*</sup> <span class="emergency">Numéro d'urgences</span> :</label>
                    <input id="emergencyInp" class="cell large-4 medium-4 large-offset-1 medium-offset-1" type="tel" name="EMERGENCY" maxlength="14" value="{$_data['emergency']}" required />
            </fieldset>
            <fieldset class="grid-x grid-margin-x">
                <legend class="cell">Photo de présentation</legend>
                
                <div id="pictureArea" class="cell grid-x">
                    <label for="pictureInp" class="cell">Photo :</label>
                        <input id="pictureInp" class="large-6 medium-6" type="file" name="PHOTO" accept="image/gif, image/jpeg, image/png" value="{$_data['photo_src']}" />
                    
                    <img id="picturePreview" class="preview large-4 medium-4 large-offset-1 medium-offset-1" src="../upload/accueil/{$_data['photo_src']}" alt="{$_data['photo_alt']}" />

                    <label for="descrPictInp" class="cell with-counter" aria-describedby="helpPictAlt"><span>Description de la photo :</span><!-- <span id="countCaracPictAlt" class="help-text">caractères: 100</span> --></label>
                        <input id="descrPictInp" type="text" name="PHOTO_ALT" maxlength="100" value="{$_data['photo_alt']}" required />
					
						<input type="hidden" name="OLD_PHOTO" value="{$_data['photo_src']}" />
						
                    <p id="helpPictAlt" class="help-text">Cette déscription sert aux lecteurs d'écran entre autre utilisé par les personnes en situation de handicap. Maximum 100 caractères.</p>
                </div>
                
                <label for="deletePicture" class="cell large-4 medium-4 for-check">Supprimer la photo :</label>
                    <input id="deletePicture" class="large-1 medium-1" type="checkbox" name="DEL_PHOTO" />
            </fieldset>
            
            <input type="reset" value="Annuler" />
            <input type="submit" value="Enregistrer" />
        </form>
</article>
<!-- <script src="../js/modifDetails.js"></script> -->
HERE;
    }
}