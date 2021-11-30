<?php

include '../fetch_data.php';
$query = "SELECT
        bon_commande.num_bdc,
        bon_commande.statut_bdc,
        bon_commande.region_bdc,
		bon_commande.nomu_bdc,
        CONCAT_WS(
            ' ',
            utilisateurs.nom_u,
            utilisateurs.prenom_u
        ) delegue_action,
        bon_commande.nom_delegue_action delegue_pf,
        bon_commande.date_bdc,
        grossiste.nom_grossiste,
		grossiste.code_grossiste,
        clients.nom_c pharmacien,
        bon_commande.nomf_bdc mat_pharmacie,
		clients.wilaya_c,
        bon_commande.total_bdc total_pvg_remise,
        bon_commande.type_bdc,
        bon_commande.remise_bdc,
        bon_commande.remise_fac,
        bon_commande.date_saisie_bdc,
        bon_commande.date_validation_bdc,
        Reference_produit.code_produit_r,
         produit_lc ,
    qte_lc               ,
    ug_lc                ,
    qteug_lc             ,
    pvg_lc               ,
    pvgug_lc             ,
    valeure_lc           ,
	remise_produit_lc    ,
    poid_lc              ,
    qte_facture_lc       ,
    qteug_facture_lc     ,
    valeure_facture_lc   ,
    remise_facture_lc    ,
    poid_facture_lc      ,
    liste_lc             ,
	observation          ,
    validation_produit   ,
    palier_bon           ,
    palier_facture       ,
	bon_commande.comment_bdc,
	bon_commande.matricule_modificateur_bdc
    
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
