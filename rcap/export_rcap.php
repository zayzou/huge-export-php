<?php
include '../security01.php';
include "../export_data.php";
include "../db_connect.php";
if (!validReferrer("rcap.php")) {
    header("Location:dashboard.php");
    die;
}
destroy();
$error = 0;
$regions = array(
    '',
    "Alger",
    "Annaba",
    "Chlef",
    "Constantine",
    "Grand Sud",
    "Oran",
    "Setif",
    "Tizi Ouzou",
    "Tlemcen"
);
if (!isset($_GET["start_date"]) || !isset($_GET["end_date"]) || !validateDate($_GET["end_date"]) || !validateDate($_GET["start_date"])) {
    $error++;
} else {
    $start_date = filterGet($_GET["start_date"]);
    $end_date = filterGet($_GET["end_date"]);
}

if (isset($_GET["region"]) && !in_array($_GET["region"], $regions, true)) {
    $error++;
} else {

    $region = filterGet($_GET["region"]);
}
if (isset($_GET["produit"])) {
    $produit = filterGet($_GET["produit"]);
}

if (isset($_GET["delegue"])) {
    $delegue = filterGet($_GET["delegue"]);
}

if ($error!=0){
    header("Location:dashboard.php");
    die;
}
$headArr = [
    "Produit",
    "QTE+UG commandé",
    "Valeur PVG remisé commandé",
    "Total Remise de commandes",
    "QTE+UG Facturé",
    "Valeur PVG remisé Facturé",
    "Total Remise de factures",
    "taux de Facturation ",
];
$query = "SELECT
ligne_commande.produit_lc,
SUM(qteug_lc) ,
ROUND(SUM(valeure_lc),2) ,
ROUND(SUM(remise_produit_lc),2) ,
IF(valeure_lc = 1, ROUND(SUM(qteug_facture_lc),2),0) ,
IF(valeure_lc = 1, ROUND(SUM(valeure_facture_lc),2),0) ,
IF(valeure_lc = 1, ROUND(SUM(remise_facture_lc),2),0) ,
IF(valeure_lc = 1, ROUND(0.01*(SUM(valeure_facture_lc)/SUM(valeure_lc)),2),0)
FROM
ligne_commande
INNER JOIN bon_commande ON ligne_commande.numbdc_lc = bon_commande.num_bdc
WHERE bon_commande.statut_bdc!='Annule' AND 
bon_commande.date_bdc BETWEEN '" . $start_date . "' AND '" . $end_date . "'
AND bon_commande.region_bdc LIKE '%" . $region . "%'
AND bon_commande.nom_delegue_action  LIKE '%" . $delegue . "%'
AND ligne_commande.produit_lc  LIKE '%" . $produit . "%'
GROUP BY
produit_lc";

// print_r($query);
$data = getData($query);
// var_dump($data);
$name = $start_date . "-" . $end_date . "-" . $region;
exportToExcel($name, $headArr, $data);
