<?php
class VBanner {
    
    
    /**
     * Constructeur de VBanner
     */
    public function __construct() {} 
    
    /**
     * Destructeur de VBanner
     */
    public function __destruct() {}
    
    /**
     * Affiche la bannière du site
     * dans laquelle se trouve le menu principale du site.
     */
    public function showBanner() {
        $memberMenu = null;     $adminMenu = null;
        
        // Lien Espace membre
        $memberLink = '<a href="../php/index.php?EX=userSpace">Espace client</a>';
        // Lien espace administrateur
        $employeeLink = '<a href="../php/index.php?EX=userSpace">Espace employé</a>';
        // Lien mon compte
        $accountLink = '<a href="../php/index.php?EX=userSpace">Mon compte</a>';
        
        // Lien de deconnection
        $disconnect = (isset($_SESSION['MEMBER'])) ? '<li class="cell medium-auto large-auto"><a href="../php/index.php?EX=userSpace&USER_SPACE=disconnect">Déconnection</a></li>' : null;
        
        
        if (isset($_SESSION['MEMBER'])) {
            if ($_SESSION['MEMBER']['status'] < USER_STAT) {
                if ($_SESSION['MEMBER']['status'] == ADMIN_STAT) {
                    $adminMenu .= '<li><a href="#" class="disabled-link">Gestion du site</a>';
                    $adminMenu .= '<ul class="my-submenu">';
                    $adminMenu .= '<li><a href="../php/index.php?EX=userSpace&USER_SPACE=detailsModif">Coordonnées du cabinet</a></li>';
                    $adminMenu .= '<li><a href="../php/index.php?EX=userSpace&USER_SPACE=schedulesModif">Horaires d\'ouvertures</a></li>';
                    $adminMenu .= '</ul>';
                    $adminMenu .= '</li>';
                    $adminMenu .= '<li><a href="../php/index.php?EX=userSpace&USER_SPACE=employeesModif">Gestion des employés</a></li>';
                }
                
                
                $memberMenu = '<li class="cell medium-auto large-auto">';
                $memberMenu .='<a href="#" class="disabled-link">Espace employé</a>';
                $memberMenu .= '<ul class="my-submenu">             <!-- Member submenu employé -->';
                $memberMenu .= $adminMenu;
                $memberMenu .= '<li><a href="../php/index.php?EX=userSpace&USER_SPACE=appointment">Rendez-vous</a></li>';
                $memberMenu .= '<li class="cell medium-auto large-auto"><a href="../php/index.php?EX=userSpace&USER_SPACE=disconnect">Déconnection</a></li>';
                $memberMenu .=   '</ul></li>';
            } elseif ($_SESSION['MEMBER']['status'] == USER_STAT) {
                $memberMenu = '<li class="cell medium-auto large-auto">';
                $memberMenu .= '<a href="#" class="disabled-link">Mon compte</a>';
                $memberMenu .= '<ul class="my-submenu">             <!-- Member submenu employé -->';
                $memberMenu .= '<li><a href="../php/index.php?EX=userSpace&USER_SPACE=updateMemberForm">Mes coordonnées</a></li>';
                $memberMenu .= '<li><a href="../php/index.php?EX=userSpace&USER_SPACE=appointment">Prendre rendez-vous</a></li>';
                $memberMenu .= '<li class="cell medium-auto large-auto"><a href="../php/index.php?EX=userSpace&USER_SPACE=disconnect">Déconnection</a></li>';
                $memberMenu .= '</ul></li>';
            }
        } else {
            $memberMenu = '<li class="cell medium-auto large-auto"><a href="../php/index.php?EX=userSpace">Espace Client</a></li>';
        }
        
        echo <<<HERE
<div class="grid-x">
    <header id="banner" class="cell medium-11 large-11 grid-x">
            <a class="cell" href="../Php/index.php" title="Accueil"><img  id="logo" src="../img/catclinic_v2.3.2.png" alt="Logo de CAT CLINIC" /></a>
    </header>
    <nav class="cell medium-11 large-11 grid-container header-menu">
        <ul class="grid-x grid-margin-x small-up-3 dropdown menu" data-dropdown-menu>
            <li class="cell medium-auto large-auto"><a href="../php/index.php">Accueil</a></li>
            <li class="cell medium-auto large-auto"><a href="../php/index.php?EX=employees">L'équipe</a></li>
            $memberMenu
            <li class="cell medium-auto large-auto">
                <a href="../php/index.php?EX=advices">Conseils</a>
                <ul class="my-submenu">             <!-- Conseils submenu -->
                    <li><a href="../php/index.php?EX=vaccin">Maladies et vaccination</a></li>
                    <li><a href="../php/index.php?EX=homeDanger">Les dangers domestiques</a></li>
                    <li><a href="../php/index.php?EX=medication">Administration des médicaments</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</div>
HERE;
    }
}