<?php
//todo search and filter are not working 
include '../fetch_data.php';
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
bon_commande.date_bdc BETWEEN '" . $_POST["start_date"] . "' AND '" . $_POST["end_date"] . "'
AND bon_commande.region_bdc LIKE '%" . $_POST["region"] . "%'
AND bon_commande.nom_delegue_action  LIKE '%" . $_POST['delegue'] . "%'
AND ligne_commande.produit_lc  LIKE '%" . $_POST['produit'] . "%'
GROUP BY
produit_lc";

fetch_data($query);
