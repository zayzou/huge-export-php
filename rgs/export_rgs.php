<?php
include '../security01.php';
include "../export_data.php";
include "../db_connect.php";
if (!validReferrer("rcap.php")) {
    header("Location:index.php");
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

if ($error != 0) {
    header("Location:index.php");
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

$query = "SELECT * FROM Reference_produit where nom_produit_r LIKE '%" . $produit. "%'";
$products = getData($query);
$sub_bons = array();
$sub_facture = array();
foreach ($products as $product) {
    $query = "SELECT
            ligne_commande.produit_lc,
            SUM(qteug_lc) as qteug_lc,
            ROUND(SUM(valeure_lc) ,2) as valeur_lc,
            ROUND(SUM(remise_produit_lc),2) as  remise_produit_lc
            FROM
                ligne_commande
            INNER JOIN bon_commande ON ligne_commande.numbdc_lc = bon_commande.num_bdc
            WHERE
            bon_commande.statut_bdc != 'Annule' AND
            bon_commande.date_bdc BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND
            ligne_commande.produit_lc LIKE  '%" . $product['nom_produit_r'] . "%'  AND
            bon_commande.region_bdc LIKE '%" . $region . "%' AND 
            bon_commande.nom_delegue_action LIKE '%" . trim($delegue) . "%'  ";

    $sub_bons = getData($query)[0];
    $valeur_lc = $sub_bons['valeur_lc'];
    $query = "SELECT

            round(SUM(qteug_facture_lc),2) qteug_facture_lc,
            round(SUM(valeure_facture_lc),2) as valeur_facture_lc,
            round(SUM(remise_facture_lc),2)  remise_facture_lc
            FROM
                ligne_commande
            INNER JOIN bon_commande ON ligne_commande.numbdc_lc = bon_commande.num_bdc
            WHERE
            bon_commande.statut_bdc != 'Annule' AND ligne_commande.validation_produit = 1 AND
            bon_commande.date_bdc BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND
            ligne_commande.produit_lc LIKE  '%" . $product['nom_produit_r'] . "%'  AND
            bon_commande.region_bdc LIKE '%" . $region . "%' AND 
            bon_commande.nom_delegue_action LIKE '%" . trim($delegue) . "%' ";
    $sub_facture = getData($query)[0];
    $valeur_facture_lc = $sub_facture['valeur_facture_lc'];
    $taux = $valeur_lc != 0 ? round((($valeur_facture_lc * 100) / $valeur_lc), 2) : 0;
    $sub_facture['taux'] = $taux;
    if ($sub_bons['produit_lc'] != null) {
        $data [] = array_merge($sub_bons, $sub_facture);
    }

}

//var_dump($data);
$name = $start_date . "-" . $end_date . "-" . $region;
exportToExcel($name, $headArr, $data);
