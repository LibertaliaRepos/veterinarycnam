<?php
class VSchedules {

    const WEEK = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
    
    public function __construct() {}
    
    public function __destruct() {}
    
    public function showForm($_data) {
//         var_dump($_data[0]);
        
        $tr = '<tr>'; 
        $checked = null;
        
        
        for ($i = 0; ($i < count($_data) || $i == 0) XOR ($_data == null && $i > 1); ++$i) {
            $td = '';
            foreach (self::WEEK as $day) {
                if ($day != 'id' || $day != 'schedule_group') {
                    if ($_data) {
                        $checked = ($_data[$i][$day] == true) ? 'checked' : 'disabled';
                    }
                   $td .= '<td><input class="line'. $i .'" type="checkbox" name="'. $i .'-'. $day .'" '. $checked .' /></td>';
                }
            }
            $value = (isset($_data[$i]['schedule_group'])) ? $_data[$i]['schedule_group'] : null;
            
            $td .= '<td><input class="line'. $i .'" type="text" name="'. $i .'-SCHED" value="'. $value .'"/></td>';
            $tr .= $td . '</tr>';
        }

        
        echo <<<HERE
<nav class="cell ariane">
    <ul class="breadcrumbs">
        <li><a href="../php/">Accueil</a></li>
        <li>Espace employé</li>
        <li>Gestion du site</li>
        <li><span class="show-for-sr">Current: </span>Modifier les horaires d'ouverture</li>
    </ul>
</nav>
<article id="grid-x-one" class="grid-x grid-margin-x">
    <h1 class="cell">Modifier les horaires d'ouverture</h1>

    <form id="schedulesForm" class="cell large-10 medium-12 small-12 large-offset-1" action="../php/index.php?EX=userSpace&USER_SPACE=schedulesInsert" method="post">
    	<table>
    		<thead>
    			<tr>
    				<th colspan="7">Jours</th>
    				<th rowspan="2">Horaires</th>
    			</tr>
    			<tr>
    				<th>Lundi</th>
    				<th>Mardi</th>
    				<th>Mercredi</th>
    				<th>Jeudi</th>
    				<th>Vendredi</th>
    				<th>Samedi</th>
    				<th>Dimanche</th>
    			</tr>
    		</thead>
    		
    		<tbody>
    			$tr
    		</tbody>
    	</table>
        <input type="reset" value="Annuler" />
        <input type="submit" value="Enregistrer" />
        <a id="addSchedGroup" class="" href="#" title="Ajouter une trache horaire">Ajouter une tranche horaire</a>
    </form>
    
</article>
<!-- <script src="../js/schedulesModif.js"></script> -->
HERE;
    }
        
    public function showPublicSchedules($_data) {
        $tr = ''; $temp = '';
        
        foreach ($_data as $tuple) {
            for ($i = 0; $i < count(self::WEEK); ++$i) {
                if (array_key_exists(self::WEEK[$i], $tuple) && $tuple[self::WEEK[$i]] == true) {
                    $temp .= self::WEEK[$i] .'//'. $tuple['schedule_group'] .';';
                }
            }
        }
        
        $temp = explode(';', $temp);
        
        for ($i = 0; $i < count(self::WEEK); ++$i) {
            $count = 0;
            while ($count < count($temp)) {
                if (preg_match('#(^'.self::WEEK[$i].')//([\w\sà]*)#', $temp[$count], $matches)) {
                    $tr .= '<tr><td>'. $matches[1] .'</td><td>'. $matches[2] .'</td></tr>';
                }
                $count++;
            }
        }
        
        $sched = <<<HERE
<table class="cell large-4 medium-10 schedules">
        <caption>Horaires d'ouvertures</caption>
        <thead  aria-disabled="false">
            <tr>
                <th>Période</th>
                <th>Horaire(s)</th>
            </tr>
        </thead>
        <tbody>
            $tr
        </tbody>
    </table>
HERE;

        return $sched;
    }
}