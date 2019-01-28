<?php 
class VFooter {

    public function __construct() {}
    
    public function __destruct() {}
    
    public function showFooter() {
        echo<<<HERE
<footer id="global-foot" class="grid-y grid-container large-margin-collapse">
    <ul class="cell grid-x grid-margin-x">
        <li class="auto cell"><a href="../php/index.php?EX=contact">Contacts</a></li>
        <li class="auto cell"><a href="../php/index.php?EX=siteMap">Plan du site</a></li>
        <li class="auto cell"><a href="#">Mention légale</a></li>
    </ul>
    <p class="cell">© - Copyright 2018/2019 - Tous droits réservé - Gilles Gander</p>
</footer>
HERE;
    }
}