<?php
include '../security01.php';
include "../export_data.php";
include "../db_connect.php";
if (!validReferrer("rgb")) {
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
if ($error != 0) {
    header("Location:index.php");
    die;
}
$headArr = [
    "N° BDC",
    "Statut",
    "Région",
    "Nom délégué action",
    "Matricule délégué action",
    "Date",
    "Grossiste",
    "Matricule pharmacie",
    "Nom Pharmacie",
    "Wilaya",
    "Total pvg remisé",
    "Type",
    "Remise du bon",
    "Remise facture",
    "Date de creation",
    "Date de validation",
    "Commentaire",
    "Code_produit",
    "Nom_produit",
    "Qte_bon",
    "Ug_bon",
    "QteUg_bon",
    "PVG_bon",
    "PvgUg_bon",
    "Valeure_bon",
    "Poid_bon",
    "Remise_produit",
    "Qte_facture",
    "QteUg_facture",
    "Valeure_facture",
    "Remise_facture",
    "Poid_facture",
    "Liste_produit",
    "palier Bon",
    "palier Facture",
    "Observation",
    "Validation_produit",
];
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
         produit_lc ,
    qte_lc               ,
    ug_lc                ,
    qteug_lc             ,
    pvg_lc               ,
    pvgug_lc             ,
    valeure_lc           ,
    poid_lc              ,
    remise_produit_lc    ,
    qte_facture_lc       ,
    qteug_facture_lc     ,
    valeure_facture_lc   ,
    remise_facture_lc    ,
    poid_facture_lc      ,
    liste_lc             ,
    palier_bon           ,
    palier_facture       ,
    observation          ,
    validation_produit   
        FROM
        ligne_commande
        INNER JOIN Reference_produit ON Reference_produit.nom_produit_r = ligne_commande.produit_lc
        INNER JOIN bon_commande ON bon_commande.num_bdc = ligne_commande.numbdc_lc
        INNER JOIN grossiste ON grossiste.code_grossiste = bon_commande.nomg_bdc
        INNER JOIN utilisateurs ON bon_commande.nom_delegue_action = utilisateurs.matricule_u
        INNER JOIN clients ON clients.id_c = bon_commande.nomf_bdc
        where bon_commande.date_bdc BETWEEN '" . $start_date . "' AND '" . $end_date . "'
       AND bon_commande.region_bdc LIKE '%" . $region . "%'";


// print_r($query);
$data = getData($query);
// var_dump($data);
$name = $start_date . "-" . $end_date . "-" . $region;
exportToExcel($name, $headArr, $data);
