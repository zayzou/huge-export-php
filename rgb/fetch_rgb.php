<?php
include '../fetch_data.php';
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
        where bon_commande.date_bdc BETWEEN '" . $_POST["start_date"] . "' AND '" . $_POST["end_date"] . "'
       AND bon_commande.region_bdc LIKE '%" . $_POST["region"] . "%'";

fetch_data($query);
