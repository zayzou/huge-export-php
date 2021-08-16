<?php
// include 'security01.php';

// if (!validReferrer("/huge_export/dashboard.php")) {
//     header("Location:dashboard.php");
// } else {
// }
// destroy();

// $regions = array(
//     '',
//     "Alger",
//     "Annaba",
//     "Chlef",
//     "Constantine",
//     "Grand Sud",
//     "Oran",
//     "Setif",
//     "Tizi Ouzou",
//     "Tlemcen"
// );
// if (!isset($_GET["start_date"]) || !isset($_GET["end_date"])) {
//     header("Location:dashboard.php");
// } else {
//     $start_date = filterGet($_GET["start_date"]);
//     $end_date = filterGet($_GET["end_date"]);
// }

// if (isset($_GET["region"]) && !in_array($_GET["region"], $regions, true)) {
//     header("Location:dashboard.php");
// } else {

//     $region = filterGet($_GET["region"]);
// }



function exportToExcel($fileName = '', $headArr = [], $data = [])
{

    ini_set('memory_limit', '1024M'); // setup program run out of memory
    ini_set('max_execution_time', 10); // set the execution time of the program, uncapped 0
    ob_end_clean(); // Clear memory
    ob_start();
    header("Content-Type: text/csv");
    header("Content-Disposition:filename=" . $fileName . '.csv');
    $fp = fopen('php://output', 'w');
    fwrite($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));
    fputcsv($fp, $headArr, ";");
    $index = 0;
    foreach ($data as $row) {
        $sub_data = array();
        foreach ($row as  $value) {
            $sub_data[] = $value;
        }
        if ($index == 1000) { // each write memory data clear 1000
            $index = 0;
            ob_flush(); // Clear memory
            flush();
        }
        $index++;
        fputcsv($fp, $sub_data, ";");
    }
    ob_flush();
    flush();
    ob_end_clean();
    exit();
}


// $headArr = [
//     "N° BDC",
//     "Statut",
//     "Région",
//     "Nom délégué PF",
//     "Matricule délégué PF",
//     "Nom délégué action",
//     "Matricule délégué action",
//     "Date",
//     "Grossiste",
//     "Matricule Grossiste",
//     "Pharmacien",
//     "Matricule Pharmacien",
//     "Wilaya",
//     "Total pvg remisé",
//     "Type",
//     "Remise du bon",
//     "Remise facture",
//     "Date de creation",
//     "Date de validation",
//     "Code_produit",
//     "Nom_produit",
//     "Qte_bon",
//     "Ug_bon",
//     "QteUg_bon",
//     "PVG_bon",
//     "PvgUg_bon",
//     "Valeure_bon",
//     "Remise_produit",
//     "Poid_bon",
//     "Qte_facture",
//     "QteUg_facture",
//     "Valeure_facture",
//     "Remise_facture",
//     "Poid_facture",
//     "Liste_produit",
//     "Observation",
//     "Validation_produit",
//     "palier Bon",
//     "palier Facture",
//     "Actions",
//     "Commentaire Bon",
//     "ACTION_LINK",
// ];

// /**
//  * return array of data 
//  */
// function getData($query)
// {
//     include('db_connect.php');
//     $statement = $pdo->prepare($query);
//     $statement->execute();
//     return $statement->fetchAll();
// }


// $name = $start_date . "-" . $end_date . "-" . $region;
// exportToExcel($name, $headArr, getData());
