<?php 
class VEmployees {
    
    // nombre de jour maximum dans un mois
    const MAX_DAYS = 31;
    //
    const MIN_YEAR_DEPTH = 20;
    // Contient tous les mois de l'année.
    const MONTHS = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
    //
    const EMPLOYEES_JOBS_TYPE = array('Docteur', 'ASV');
    
    public function __construct() {}
    
    public function __destruct() {}
    
    /**
     * Affiche les employées dans un tableau.
     */
    private function showEmployeesTable($_data) {
        unset($_data['idModification']);
        // Génération des lignes du tableau en fonction de l'employé.
        $tr = '';
        foreach ($_data as $employee) {
            $date = timeToStringFormat($employee['hiring_date']);
            $tr .= '<tr>
                    <td>'.$employee['name'].'</td>
                    <td>'.$employee['firstname'].'</td>
                    <td>'. $date .'</td>
                    <td>'.$employee['job'].'</td>
                    <td><a href="../php/index.php?EX=userSpace&USER_SPACE=employeesModif&ID='. $employee['id'] .'#employeeForm" title="Modifier"><img src="../img/edit-icon.png" alt="Modifier" /></a></td>
                    <td><a href="../php/index.php?EX=userSpace&USER_SPACE=employeesDelete&ID='. $employee['id'] .'" title="Supprimer"><img src="../img/delete-icon.png" alt="Supprimer" /></a></td>
                </tr>';
        }
        
        echo <<<HERE
<nav class="cell ariane">
    <ul class="breadcrumbs">
        <li><a href="../php/">Accueil</a></li>
        <li><span class="show-for-sr">Current: </span>L'équipe</li>
    </ul>
</nav>
<article id="grid-x-one" class="grid-x grid-margin-x employee-modif">
    <h1 class="cell">Gestion des employés</h1>
    <section class="cell">
        <h2>Vos employés</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date d'arrivé dans le service</th>
                    <th>Poste</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
                $tr
            </tbody>
        </table>
    </section>
HERE;

        return;
    }// showEmployeesTables()
        
    /**
     * Affiche le formulaire d'ajout ou de modification d'un employé.
     */
    private function showEmployeesForm($_id = null) {
        $daysOpts = null;   $monthsOpts = null;     $yearsOpts = null;      $currentYear = null;
        $jobsOpts = null;   $hiddenInput = null;    $action = null;     $date = null;
        
        $updateValues = array(
            'name'          =>      null,
            'firstname'     =>      null,
            'description'   =>      null,
            'photo'         =>      MEmployees::EMPTY_AVATAR,
            'submit'        =>      'Ajouter'
        );
        
        $action = '../php/index.php?EX=userSpace&USER_SPACE=employeesInsert';
        
        if ($_id) {
           $mEmployees = new MEmployees($_id);
           $data = $mEmployees->Select();
           strip_xss($data, true);
           
//            var_dump($data);
           
           $action = '../php/index.php?EX=userSpace&USER_SPACE=employeesUpdate&ID='. $data['id'];
           $updateValues = array(
               'name'          =>      $data['name'],
               'firstname'     =>      $data['firstname'],
               'description'   =>      $data['description'],
               'photo'         =>      $data['photo'],
               'submit'        =>      'Modifier'
           );
           $date = getdate(intval($data['hiring_date']));
           $hiddenInput = '<input type="hidden" value="'. $updateValues['photo'] .'" name="OLD_PHOTO" />';
        }
        
        // Génération des <option> pour les <select> permettant de renségner
        // la date d'embauche de l'employé et le type de poste.
        
        
        // Contient les options des jours.
        $daysOpts = '<option id="dayAriaLabel" value="">Jour</option>'; 
        for ($i = 1; $i <= self::MAX_DAYS; ++$i) {
            $selected = ($date && ($date['mday'] == $i)) ? 'selected' : null;
            $day = ($i < 10) ? '0'.$i : $i;
            $daysOpts .= '<option value="'. $day .'" '. $selected .'>'. $day .'</option>';
        }
        
        // Contient les options des mois.
        $monthsOpts = '<option id="monthAriaLabel" value="">Mois</option>';
        foreach (self::MONTHS as $key => $month) {
            $selected = ($date && ($date['mon'] == ($key + 1))) ? 'selected' : null;
            $key = ($key < 10) ? '0'. ($key + 1) : ($key + 1);
            $monthsOpts .= '<option value="'. $key .'" '. $selected .'>'. $month .'</option>';
        }
        
        
        // contient les options des années.
        $yearsOpts = '<option id="yearAriaLabel" value="">Année</option>';
        $currentYear = getdate(time())['year']; // Année en cours.
        for ($i = 0; $i <= self::MIN_YEAR_DEPTH; ++$i) {
            $year = $currentYear - $i;
            $selected = ($date && ($date['year'] == $year)) ? 'selected' : null;
            
            $yearsOpts .= '<option value="'. $year .'" '. $selected .'>'. $year .'</option>';
        }
        
        // Contient les options pour le type de poste occupé.
        $jobsOpts = '<option value="">Poste</option>';
        foreach (self::EMPLOYEES_JOBS_TYPE as $job) {
            $selected = ($_id && ($data['job'] == $job)) ? 'selected' : null;
            $jobsOpts .= '<option value="'. $job .'" '. $selected .'>'. $job .'</option>';
        }
        
        echo <<<HERE
<section class="cell grid-container grid-x">
        <h2 class="cell">Ajouter un employé</h2>
        <form id="employeeForm" class="cell large-10 large-offset-1 grid-container" action="$action" method="post" enctype="multipart/form-data">
            <fieldset class="grid-x grid-margin-x">
                <legend class="cell">Information sur l'employé</legend>
                <p id="addEmployHText" class="help-text cell"><sup>*</sup> : Champ obligatoire</p>

                <label for="nameEmployInp" class="cell large-4 medium-4 large-offset-2 medium-offset-2" aria-describedby="addEmployHText"><sup>*</sup> Nom :</label>
                    <input id="nameEmployInp" class="cell large-4 medium-4" type="text" name="NAME" value="{$updateValues['name']}" required />

                <label for="firstnameEmployInp" class="cell large-4 medium-4 large-offset-2 medium-offset-2" aria-describedby="addEmployHText"><sup>*</sup> Prénom :</label>
                    <input id="firstnameEmployInp" class="cell large-4 medium-4" type="text" name="FIRSTNAME" value="{$updateValues['firstname']}" required />

                <fieldset class="cell grid-container grid-x grid-margin-x">
                    <legend class="cell large-4 medium-10 large-offset-1 medium-offset-1" aria-describedby="addEmployHText"><sup>*</sup> Date d'embauche :</legend>

<!--                    <label class="large-2" for="daycSelect">Jour :</label>-->
                        <select id="daySelect" class="cell large-2 medium-4 small-4 large-offset-4" name="DAY" aria-labelledby="dayAriaLabel" required>
                            $daysOpts
                        </select>

<!--                    <label for="monthSelect" class="large-1">Mois :</label>-->
                        <select id="monthSelect" class="cell large-2 medium-4 small-4" name="MONTH" aria-labelledby="monthAriaLabel" required>
                            $monthsOpts
                        </select>

<!--                    <label for="yearSelect" class="large-1">Année :</label>-->
                        <select id="yearSelect" class="cell large-2 medium-4 small-4" name="YEAR" aria-labelledby="yearAriaLabel" required>
                            $yearsOpts
                        </select>
                </fieldset>

                <label for="jobSelect" class="cell large-4 medium-4 large-offset-2 medium-offset-2" aria-describedby="addEmployHText"><sup>*</sup> Poste occupé :</label>
                    <select id="jobSelect" class="cell large-3 medium-3" name="JOB" required>
                        $jobsOpts
                    </select> 
                <label for="descriptionAera" class="cell" aria-describedby="addEmployHText"><sup>*</sup> Description :</label>
                <textarea id="descriptionArea" name="DESCRIPTION" required>{$updateValues['description']}</textarea>

                <div id="pictureArea" class="cell grid-x grid-margin-x">
                    <div id="disablablePict" class="cell">
                        <label for="photoEmployInp" >Photo :</label>
                            <input id="photoEmployInp" type="file" accept="image/jpeg, image/png" name="PHOTO" />
                            
                            <img id="picturePreview" class="" src="../upload/employees/{$updateValues['photo']}"  alt="Aperçu de la photo" />
                    </div>
                      
                        <label for="delPhoto" class="cell large-3 medium-3 large-offset-2 medium-offset-2">Supprimer la photo :</label>
                        <input id="delPhoto" class="cell large-1 medium-1" type="checkbox" name="DEL_PHOTO" />               
                </div>
                     
                <input class="cell large-2 medium-2 small-5 large-offset-3 medium-offset-3" type="reset" value="Annuler" />
                <input class="cell large-2 medium-2 small-5 large-offset-2 small-offset-1" type="submit" value="{$updateValues['submit']}" />
            </fieldset>
            $hiddenInput
        </form>
    </section>
</article>
<script src="../js/modifEmployees.js"></script>
HERE;

        return;
    }// showEmployeesForm()
    
        
    public function showEmployeesModifPage($_data) {
        $this->showEmployeesTable($_data);
        $this->showEmployeesForm($_data['idModification']);
    }
    
    public function showEmployeesPage($_data) {
        $section = '';  $label = null;
        
//         var_dump($_data);
        
        foreach ($_data as $employee) {
            $label = ($employee['job'] == 'Docteur') ? '<abbr title="docteur">Dr.</abbr>' : 'Assistant';
            
            $section .= '<section class="cell employees"><h2>'. $label . ' '. $employee['firstname'] .' '. $employee['name'] .'</h2>
        <img src="../upload/employees/'. $employee['photo'] .'" alt="photo de '. $employee['firstname'] .' '. $employee['name'] .'" />
        <div>'. $employee['description'] .'</div></section>';
        }
        
        echo <<<HERE
<nav class="cell ariane">
    <ul class="breadcrumbs">
        <li><a href="../php/">Accueil</a></li>
        <li><span class="show-for-sr">Current: </span>L'équipe</li>
    </ul>
</nav>
<article id="grid-x-one" class="grid-x grid-margin-x">
    <h1 class="cell">L'équipe</h1>
    $section
</article>
HERE;
    }
}

?>