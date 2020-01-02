<?php

include_once 'app/Conexio.inc.php';
include_once 'app/RepositoriAssignatures.inc.php';
$titol = 'Principal';
Conexio::obrir_conexio();
$conexio = Conexio::obtenir_conexio();
$total_assign = RepositoriAssignatures:: obtenir_num_assigns(Conexio::obtenir_conexio());
Conexio :: tancar_conexio();
require 'vendor/autoload.php';
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('template.xlsx');


$sql = "SELECT * FROM Professors WHERE admin=0 ";

$sentencia = $conexio->prepare($sql);
$sentencia->execute();
$resultat = $sentencia->fetchAll();
$noms = array();
$globals = array();
$globals_q1 = array();
$globals_q2 = array();

foreach ($resultat as $fila) {
    $sigles_nom = explode(" ", $fila['nom']);
    $sigles_cognom = explode(" ", $fila['cognoms']);
    $sigles_tot = array_merge($sigles_nom, $sigles_cognom);
    $profe = '';
    foreach ($sigles_tot as $paraula) {
        $profe = $profe . $paraula[0];
    }

    $noms[] = [$profe];
    $nom_profe = $fila['nom'] . ' ' . $fila['cognoms'];
    $sql2 = "SELECT  assignatura, tipus, quadri, sum(grups) as grups FROM Globals WHERE professor= '" . $nom_profe . "' GROUP BY assignatura, tipus,quadri";

    $sentencia2 = $conexio->prepare($sql2);
    $sentencia2->execute();
    $resultat2 = $sentencia2->fetchAll();
    $global2 = array();
    $global2_q1 = array();
    $global2_q2 = array();
    foreach ($resultat2 as $fila2) {

        $global2[] = $fila2['grups'];
        
        if ($fila2['quadri']=='Q1'){
            $global2_q1[] = $fila2['grups'];
        }
        
         if ($fila2['quadri']=='Q2'){
            $global2_q2[] = $fila2['grups'];
        }
        
        
        
    }
    $globals[] = $global2;
    $globals_q1[]=$global2_q1;
    $globals_q2[]=$global2_q2;
    
}


$info_assign = array();
$assign = array();
$assign_q1 = array();
$assign_q2 = array();
$grups = array();
$grups_q1 = array();
$grups_q2 = array();
$pads = array();
$pads_q1 = array();
$pads_q2 = array();
$sql3 = "SELECT * FROM Assignatures GROUP BY nom, tipus, quadri ";

$sentencia3 = $conexio->prepare($sql3);
$sentencia3->execute();
$resultat3 = $sentencia3->fetchAll();

foreach ($resultat3 as $fila3) {
    $assign[] = $fila3['nom'] . ' ' . strtoupper($fila3['tipus'][0]);
    $grups[] = intval($fila3['grups']);
    $pads[] = intval($fila3['credits']) * 3 * intval($fila3['grups']);
    $info_assign[] = [$fila3['nom'], $fila3['tipus'], $fila3['quadri'], $fila3['credits'], $fila3['grups']];

    if ($fila3['quadri'] == 'Q1') {
        $grups_q1[] = intval($fila3['grups']);
        $assign_q1[] = $fila3['nom'] . ' ' . strtoupper($fila3['tipus'][0]);
        $pads_q1[] = intval($fila3['credits']) * 3 * intval($fila3['grups']);
    }
    if ($fila3['quadri'] == 'Q2') {
        $grups_q2[] = intval($fila3['grups']);
        $assign_q2[] = $fila3['nom'] . ' ' . strtoupper($fila3['tipus'][0]);
        $pads_q2[] = intval($fila3['credits']) * 3 * intval($fila3['grups']);
    }
}


$worksheet = $spreadsheet->setActiveSheetIndex(0);
$worksheet = $spreadsheet->getActiveSheet()->fromArray($noms, '', 'A6');
$worksheet = $spreadsheet->getActiveSheet()->fromArray($grups, '', 'D2');
$worksheet = $spreadsheet->getActiveSheet()->fromArray($pads, '', 'D4');
$worksheet = $spreadsheet->getActiveSheet()->fromArray($assign, '', 'D5');
$worksheet = $spreadsheet->getActiveSheet()->fromArray($globals, '', 'D6');


$worksheet2 = $spreadsheet->setActiveSheetIndex(1);
$worksheet2 = $spreadsheet->getActiveSheet()->fromArray($noms, '', 'A6');
$worksheet2 = $spreadsheet->getActiveSheet()->fromArray($grups_q1, '', 'D2');
$worksheet2 = $spreadsheet->getActiveSheet()->fromArray($assign_q1, '', 'D5');
$worksheet2 = $spreadsheet->getActiveSheet()->fromArray($pads_q1, '', 'D4');
$worksheet2 = $spreadsheet->getActiveSheet()->fromArray($globals_q1, '', 'D6');

$worksheet3 = $spreadsheet->setActiveSheetIndex(2);
$worksheet3 = $spreadsheet->getActiveSheet()->fromArray($noms, '', 'A6');
$worksheet3 = $spreadsheet->getActiveSheet()->fromArray($grups_q2, '', 'D2');
$worksheet3 = $spreadsheet->getActiveSheet()->fromArray($assign_q2, '', 'D5');
$worksheet3 = $spreadsheet->getActiveSheet()->fromArray($pads_q2, '', 'D4');
$worksheet3 = $spreadsheet->getActiveSheet()->fromArray($globals_q2, '', 'D6');

$worksheet4 = $spreadsheet->setActiveSheetIndex(3);
$worksheet4 = $spreadsheet->getActiveSheet()->fromArray($info_assign, '', 'A2');
$worksheet4 = $spreadsheet->getActiveSheet()->setTitle('Assignatures');

$worksheet5 = $spreadsheet->setActiveSheetIndex(0);

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('excel_emplenat.xlsx');
?>