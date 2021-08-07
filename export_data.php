<?php
include 'security01.php';
var_dump($_SESSION);
if (!validReferrer("/huge_export/dashboard.php")) {
    header("Location:dashboard.php");
}
destroy();

// var_dump($_SESSION);
/**
Export csv file for exporting large amounts of data
 */
//todo only authorized person can export report
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
if (!isset($_GET["start_date"]) || !isset($_GET["end_date"])) {
    header("Location:dashboard.php");
} else {
    $start_date = filterGet($_GET["start_date"]);
    $end_date = filterGet($_GET["end_date"]);
}

if (isset($_GET["region"]) && !in_array($_GET["region"], $regions, true)) {
    header("Location:dashboard.php");
} else {

    $region = filterGet($_GET["region"]) ;
}
function filterGet($param)
{
    return htmlentities($param, ENT_QUOTES, 'UTF-8');
}


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


$headArr = [
    "N° BDC",
    "Statut",
    "Région",
    "Nom délégué PF",
    "Matricule délégué PF",
    "Nom délégué action",
    "Matricule délégué action",
    "Date",
    "Grossiste",
    "Matricule Grossiste",
    "Pharmacien",
    "Matricule Pharmacien",
    "Wilaya",
    "Total pvg remisé",
    "Type",
    "Remise du bon",
    "Remise facture",
    "Date de creation",
    "Date de validation",
    "Code_produit",
    "Nom_produit",
    "Qte_bon",
    "Ug_bon",
    "QteUg_bon",
    "PVG_bon",
    "PvgUg_bon",
    "Valeure_bon",
    "Remise_produit",
    "Poid_bon",
    "Qte_facture",
    "QteUg_facture",
    "Valeure_facture",
    "Remise_facture",
    "Poid_facture",
    "Liste_produit",
    "Observation",
    "Validation_produit",
    "palier Bon",
    "palier Facture",
    "Actions",
    "Commentaire Bon",
    "ACTION_LINK",
];

/**
 * return array of data 
 */
function getData()
{
    global $region;
    include('db_connect.php');
    $query = "SELECT
    bon_commande.num_bdc,
    bon_commande.statut_bdc,
    bon_commande.region_bdc,
    CONCAT_WS(
        ' ',
        utilisateurs.nom_u,
        utilisateurs.prenom_u
    ) delegue_action,
    bon_commande.nomu_bdc delegue_pf,
    bon_commande.date_bdc,
    grossiste.nom_grossiste,
    bon_commande.nomf_bdc mat_pharmacie,
    clients.nom_c pharmacien,
    clients.wilaya_c,
    bon_commande.total_bdc total_pvg_remise,
    bon_commande.type_bdc,
    bon_commande.remise_bdc,
    bon_commande.remise_fac,
    bon_commande.date_saisie_bdc,
    bon_commande.date_validation_bdc,
    bon_commande.comment_bdc,
    Reference_produit.code_produit_r,
    ligne_commande.*,
    bon_commande.num_bdc ACTION_LINK
    FROM
    ligne_commande
    INNER JOIN Reference_produit ON Reference_produit.nom_produit_r = ligne_commande.produit_lc
    INNER JOIN bon_commande ON bon_commande.num_bdc = ligne_commande.numbdc_lc
    INNER JOIN grossiste ON grossiste.code_grossiste = bon_commande.nomg_bdc
    INNER JOIN utilisateurs ON bon_commande.nom_delegue_action = utilisateurs.matricule_u
    INNER JOIN clients ON clients.id_c = bon_commande.nomf_bdc
    WHERE " . 'bon_commande.date_bdc BETWEEN "' . $_GET["start_date"] . '" AND "' . $_GET["end_date"] . '" ';
    if (isset($_GET["region"])) {
        $query .= ' AND region_bdc LIKE "%' . $region . '%"';
    }
    $statement = $pdo->prepare($query);
    $statement->execute();
    return $statement->fetchAll();
}


$name = $start_date . "-" . $end_date . "-" . $region;
exportToExcel($name, $headArr, getData());