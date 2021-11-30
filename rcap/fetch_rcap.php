<?php
include('../db_connect.php');
$data = array();
if ($_POST['start_date'] != '' || $_POST['end_date'] != '') {
    $query = "SELECT * FROM Reference_produit where nom_produit_r LIKE '%" . $_POST["produit"] . "%'";
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
            bon_commande.date_bdc BETWEEN '" . $_POST["start_date"] . "' AND '" . $_POST["end_date"] . "' AND
            ligne_commande.produit_lc LIKE  '%" . $product['nom_produit_r'] . "%'  AND
            bon_commande.region_bdc LIKE '%" . $_POST["region"] . "%' AND 
            bon_commande.nom_delegue_action LIKE '%" . trim($_POST["delegue"]) . "%'  ";
        print_r($query);
        break;
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
            bon_commande.date_bdc BETWEEN '" . $_POST["start_date"] . "' AND '" . $_POST["end_date"] . "' AND
            ligne_commande.produit_lc LIKE  '%" . $product['nom_produit_r'] . "%'  AND
            bon_commande.region_bdc LIKE '%" . $_POST["region"] . "%' AND 
            bon_commande.nom_delegue_action LIKE '%" . trim($_POST["delegue"] ). "%' ";

        $sub_facture = getData($query)[0];
        $valeur_facture_lc = $sub_facture['valeur_facture_lc'];
        $taux = $valeur_lc != 0 ? round((($valeur_facture_lc * 100) / $valeur_lc),2) : 0;
        $sub_facture['taux'] = $taux;
        if ($sub_bons['produit_lc'] != null) {
            $data [] = array_merge($sub_bons, $sub_facture);
        }

    }

}

$export = array();
//var_dump($data);
foreach ($data as $row) {
    $sub = array();
    foreach ($row as $value) {
        $sub[] = $value;
    }
    $export[] = $sub;
}
$total_rows = count($export);

$output = array(
    "draw" => intval($_POST["draw"]),
    "recordsTotal" => $total_rows,
    "recordsFiltered" => $total_rows,
    "data" => $export
);
echo json_encode($output);
