<?php
class VMember {
    
    public function __construct(){}
    
    public function __destruct(){}
    
    public function showUpdateForm() {
        
        echo <<<HERE
<article id="grid-x-one" class="grid-x grid-margin-x memDetails">
<nav class="cell ariane">
    <ul class="breadcrumbs">
        <li><a href="../php/">Accueil</a></li>
        <li>Mon compte</li>
        <li><span class="show-for-sr">Current: </span>Modifier mes coordonnées</li>
    </ul>
</nav>
    <h1 class="cell">Modifier mes coordonnées</h1>
    <form id="upMemDetails" class="cell grid-container grid-x grid-margin-x" action="../php/index.php?EX=userSpace&USER_SPACE=updateMember" method="post">
        <p class="help-text cell">Champ obligatoire : <sup>*</sup></p>
        <ul class="accordion cell" data-accordion data-multi-expand="true">
            <li class="accordion-item" data-accordion-item>
                <a id="emailTitle" href="#" class="accordion-title">Adresse de messagerie</a>
                
                <fieldset class="accordion-content" data-tab-content aria-label="emailTitle" >
                    <label for="oldMail">Ancienne adresse de messagerie : <sup>*</sup></label>
                        <input id="oldMail" type="email" name="OLD_MAIL" />
                    
                    <label for="newMail1">Nouvelle adresse de messagerie : <sup>*</sup></label>
                        <input id="newMail1" type="email" name="NEW_MAIL1" data-parentform="upMemDetails" data-test  data-mail-exists />
                    
                    <label for="newMail2">Corfirmer nouvelle messagerie : <sup>*</sup></label>
                    <input id="newMail2" type="email" name="NEW_MAIL2" data-parentform="upMemDetails" data-test />
                </fieldset>
            </li>
            <li class="cell accordion-item" data-accordion-item>
                <a id="pwdTitle" href="#" class="accordion-title">Mot de passe</a>
                
                <fieldset class="accordion-content" data-tab-content aria-labelledby="pwdTitle">
                    
                    <label for="oldPwd">Ancien mot de passe : <sup>*</sup></label>
                        <input id="oldPwd" type="password" name="OLD_PWD" />
                    
                    <label for="newPwd1">Nouveaux mot de passe : <sup>*</sup></label>
                        <input id="newPwd1" type="password" name="NEW_PWD1" data-test />
                    
                    <label for="newPwd2">Confirmer mot de passe : <sup>*</sup></label>
                        <input id="newPwd2" type="password" name="NEW_PWD2" data-parentform="upMemDetails" data-test />
                </fieldset>
            </li>
            <li class="cell accordion-item is-active more-details" data-accordion-item>
                <a href="#" class="accordion-title">Informations complémentaires</a>
                <fieldset class="accordion-content more-details" data-tab-content aria-labelledby="phoneTitle">

                    <p id="phoneHelp">
                        Votre numéro de téléphone peut nous etre utile dans le cas où
                        vous avez pris rendez-vous depuis notre site et que pour un cas exceptionnel
                        nous ne pouvons pas satisfaire à celui-ci.
                        Si vous renseignez votre numéro de téléphone nous pourrons vous appeler pour
                        fixer un autre rendez-vous.
                    </p>
                    <div>
                        <label for="phoneMemInp">Téléphone :</label>
                            <input id="phoneMemInp" type="text" name="MEM_PHONE" value="{$_SESSION['MEMBER']['phone']}" maxlength="14" aria-describedby="phoneHelp" />
                    </div>
                </fieldset>
            </li>
        </ul>
        <input class="cell large-2 medium-2 medium-offset-2 large-offset-2" type="reset" value="Annuler" />
        <input class="cell large-2 medium-2 medium-offset-4 large-offset-4" type="submit" value="Enregistrer" />
    </form>
    <button id="delAccount" class="alert button" type="button" data-open="unsubMem">Désinscription</button>
    <aside id="unsubMem" class="tiny reveal" data-reveal>
        <h1>Désinscription</h1>
        <div class="reveal-content">
            <p>
                <img src="../img/unsubscribe.png" alt="Attention désinscription" />
                <span>Etes-vous sur de vouloir vous désinscrire du site de CAT CLINIC ?</span>
            </p>
        </div>
        <p id="confirmBTN">
            <button class="close button alert" type="button" data-close aria-label="Close modal">Non</button>
            <button id="confimSupMem" class="close button success" type="button" data-close aria-label="Close modal">Oui</button>
        </p>
    </aside>
</article>
HERE;
    }
}