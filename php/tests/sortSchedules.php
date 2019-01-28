<?php
require('../inc/require.inc.php');

$week = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');

$mShed = new MSchedules();
$data = $mShed->selectAll();
var_dump($data);
$temp = '';

foreach ($data as $tuple) {
    for ($i = 0; $i < count($week); ++$i) {
        if (array_key_exists($week[$i], $tuple) && $tuple[$week[$i]] == true) {
            $temp .= "{$week[$i]}//{$tuple['schedule_group']};";
        }
    }
}


$temp = explode(';', $temp);


$sortedSched = array();

for ($i = 0; $i < count($week); ++$i) {
    $count = 0;
    while ($count < count($temp)) {
        if (preg_match('#(^'.$week[$i].')//([\w\sà]*)#', $temp[$count], $matches)) {
            $sortedSched[$i] = array($matches[1], $matches[2]);
        }
        $count++;
    }
}

var_dump($sortedSched);

$tr = '';
foreach ($sortedSched as $day) {
    $tr .= "<tr><td>{$day[0]}</td><td>{$day[1]}</td></tr>";
}

var_dump($tr);