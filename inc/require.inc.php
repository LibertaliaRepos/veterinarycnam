<?php
// identifient de connection à la base de donnée
define('DATABASE', 'mysql:host=sql.franceserv.fr;dbname=libertalia_db5;charset=utf8');
define('LOGIN', '*********');
define('PASSWORD', '***********');

//constante qui active ou désactive les erreurs SQL:
// true : actif,
// false : inactif.

define('ERROR_SQL', true);
// define('ERROR_SQL', false);

// Définition des diférents status d'utilisateur:
// 0 : Administrateur,
// 1 : Employé,
// 2 : utilisateur ordinaire.
define('ADMIN_STAT', 0);
define('EMPLOYEE_STAT', 1);
define('USER_STAT', 2);

define('GOOGLE_API_KEY', 'AIzaSyDxTE-vsnAFqupCpWG9D3Q7e-l0-3Yh_Gs');

/**
 * Vérifit que le membre est bien un Admin.
 *
 * Rediction vers l'accueil si le membre n'est est pas un admin.
 */
function VerifAdmin() {
    if ($_SESSION['MEMBER']['status'] > ADMIN_STAT) {
        header('location: ../php/');
    }
}// VerifAdmin ()

function VerifEmploy() {
    if ($_SESSION['MEMBER']['status'] > EMPLOYEE_STAT) {
        header('location: ../php/');
    }
}

function VerifMember() {
    if ($_SESSION['MEMBER']['status'] > USER_STAT) {
        header('location: ../php/');
    }
}

// Définition des diférents status des messages de rendez-vous:
// 0 : nouveaux,
// 1 : envoyés,
// 2 : archive
define('NEW_MESSAGE', 0);
define('SENT_MESSAGE', 1);
define('ARCHIVE_MESSAGE', 2);


// Définition des chemin des différents répertoire d'upload
// Répertoire général d'upload.
define('UPLOAD_PATH', str_replace('inc', 'upload', realpath('../inc')) . '/');
// Répertoire pour la photo d'accueil.
define('UP_ACCUEIL', UPLOAD_PATH . 'accueil/');
// Répertoire pour la photo des employé.
define('UP_EMPLOYEES', UPLOAD_PATH . 'employees/');
// Répertoire pour le stockage des fichier pdf.
define('UP_PDF', UPLOAD_PATH . 'pdf/');


/**
 * Chargement automatic des classes
 * @param $class
 */
require ('../externModul/vendor/autoload.php');
// require ('../view/VAjax.view.php');

function my__autoload($class) {
    switch ($class[0]) {
        case 'V':       require_once(__DIR__.'/../view/'. $class .'.view.php');      break;
        case 'M':       require_once(__DIR__.'/../mod/'. $class .'.mod.php');        break;
        case 'C':       require_once(__DIR__.'/../class/'. $class .'.class.php');    break;
    }
}// __autoload($class)

spl_autoload_register('my__autoload');

/**
 * Supprime les tag html de $val
 * Si $_froala vaux true, laisse les tags html généré par l'éditeur.
 * 
 * @param $val
 * @param boolean [$_froala] 
 */
function strip_xss(&$val, $_froala = false) {
    $froala_tag = '<a><abbr><address><area><article><aside><audio><b><base><bdi><bdo><blockquote><br><button><canvas><caption><cite><code><col><colgroup><datalist><dd><del><details><dfn><dialog><div><dl><dt><em><embed><fieldset><figcaption><figure><footer><form><h2><h3><h4><h5><h6><header><hgroup><hr><i><img><input><ins><kbd><keygen><label><legend><li><link><main><map><mark><menu><menuitem><meter><nav><noscript><object><ol><optgroup><option><output><p><param><pre><progress><queue><rp><rt><ruby><s><samp><style><section><select><small><source><span><strike><strong><sub><summary><sup><table><tbody><td><textarea><tfoot><th><thead><time><title><tr><track><u><ul><var><video><wbr>';
    
    if (is_array($val)) {
        array_walk($val, 'strip_xss');
    } elseif (is_string($val)) {
        if ($_froala) {
            strip_tags($val, $froala_tag);
        } else {
            strip_tags($val);
        }
    }
    return;
}// strip_xss(&$val)

/**
* Mise en forme d'un fichier pour le téléchargement
 * @param array correspondant au nom du fichier téléchargé
 *
 * @return string fichier mis en forme
 */
function upload($file) {
	// Découpe $file['name'] en tableau avec comme sÃ©parateur le point
	$tab = explode('.', $file['name']);
	    
	// Transforme les caractères accentués en entités HTML
	$fichier = htmlentities($tab[0], ENT_NOQUOTES);
	    
	// Remplace les entités HTML pour avoir juste le premier caractères non accentués
	$fichier = preg_replace('#&([A-za-z])(?:acute|grave|circ|uml|tilde|ring|cedil|lig|orn|slash|th|eg);#', '$1', $fichier);

    // Elimination des caractères non alphanumériques
    $fichier = preg_replace('#\W#', '', $fichier);
    
    // Troncation du nom de fichier Ã  25 caractères
    $fichier = substr($fichier, 0, 25);
    
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    
    // Choix du format d'image
    if (exif_imagetype($file['tmp_name']) != false) {
        switch(exif_imagetype($file['tmp_name'])) {
            case IMAGETYPE_GIF  : $format = '.gif'; break;
            case IMAGETYPE_JPEG : $format = '.jpg'; break;
            case IMAGETYPE_PNG  : $format = '.png'; break;
        }
    }    
    
    // Ajout du time devant le fichier pour obtenir un fichier unique
    $fichier = time() . '_' . $fichier . $format;
    
    return $fichier;
} // upload($file)

/**
 * Créer un objet image à partir d'un fichier image donné.
 * Redimensionne l'image en fonction de sont ratio.
 * 
 * @param $file                image à redimensionner 
 * @param int $width_new       largeur en pixel de la futur image
 * @param int $height_new      hauteur en pixel de la futur image
 * @return resource            image redimmensionnée
 */
function redimensionne($file, $width_new, $height_new) {
    // Retourne les dimensions et le mime à  partir du fichier image
    $tab = getimagesize($file);
    $width_old = $tab[0];
    $height_old = $tab[1];
    $mime_old = $tab['mime'];
    
    // Ratio pour la mise )  l'échelle
    $ratio = $width_old/$height_old;
    
    // Redimensionnement suivant le ratio
    if ($width_new/$height_new > $ratio) {
        $width_new = $height_new*$ratio;
    } else {
        $height_new = $width_new/$ratio;
    }
    
    // Nouvelle image redimensionnée
    $image_new = imagecreatetruecolor($width_new, $height_new);
    
    // Création d'une image à  partir du fichier image et suivant le mime
    switch ($mime_old) {
        case 'image/png' :  $image_old = imagecreatefrompng($file);     break;
        case 'image/jpeg' : $image_old = imagecreatefromjpeg($file);    break;
        case 'image/gif' :  $image_old = imagecreatefromgif($file);     break;
    }
    
    // Copie et redimensionne l'ancienne image dans la nouvelle
    imagecopyresampled($image_new, $image_old, 0, 0, 0, 0, $width_new, $height_new, $width_old, $height_old);
    
    // Retourne la nouvelle image redimensionnée (Attention ce n'est pas un fichier mais une image)
    return $image_new;
} // redimensionne($file, $width_new, $height_new)


/**
 * Créer un fichier image (.png, .jpeg ou .gif) à partir d'un objet image
 * 
 * @param string $_index        index de la variable global $_FILES.
 * @param string $_folder       Chemin du dossier dans lequel sera créer le fichier image.
 * @return string|boolean       Retourne le nom du fichier | Retourne false en cas d'erreur.
 */
function uploadPhoto($_index, $_folder) {
    if (isset($_FILES[$_index]) && $_FILES[$_index]['error'] === UPLOAD_ERR_OK) {
        $file_new = upload($_FILES[$_index]);
        $image_new = redimensionne($_FILES[$_index]['tmp_name'], 800, 600);
        switch ($_FILES[$_index]['type']) {
            case 'image/png'  : imagepng($image_new, $_folder . $file_new, 0);  	    break;
            case 'image/jpeg' : imagejpeg($image_new, $_folder . $file_new, 100);     break;
            case 'image/gif' : imagegif($image_new, $_folder . $file_new, 0);         break;
        }
        return $file_new;
    } else {
        return false;
    }
}

/**
 * Formate un timestamp sous forme l'itéral:
 * Le JJ/MM/AAAA .
 * 
 * @param int $_timestamp
 * @param bool $_hour  à true le formatage contiendra les heures et minutes. Par défault $_hour = false.
 *
 * @return string
 */
function timeToStringFormat($_timestamp, $_hour = false) {
    $date = getdate($_timestamp);
    
    $day = ($date['mday'] > 9) ? $date['mday'] : '0'.$date['mday'];
    $month = ($date['mon'] > 9) ? $date['mon'] : '0'.$date['mon'];
   
    $format = "$day/$month/{$date['year']}";
    if ($_hour) {
        
        $min = ($date['minutes'] > 9) ? $date['minutes'] : '0'.$date['minutes'];
        
        $format .= " à {$date['hours']}h$min";
    }
    
    return $format;
}

/**
 * Formate le label abrégé des personne : Mrs | Mme | Mlle
 * 
 * @param string $_shortLabel
 * @return NULL | string Monsieur | Madame | Mademoiselle
 */
function personLabel($_shortLabel) {
    switch ($_shortLabel) {
        case 'Mrs':      $label = 'Monsieur';         break;
        case 'Mlle':     $label = 'Mademoiselle';     break;
        case 'Mme':     $label = 'Madame';            break;
        
        default:  $label = null;
    }
    
    return $label;
}

/**
 * Validation de l'adresse email (RFC822)
 * 
 * @param string $_email
 * @return boolean
 */
function emailValidation($_email) {
    return (filter_var($_email, FILTER_VALIDATE_EMAIL)) ? true : false;
}



