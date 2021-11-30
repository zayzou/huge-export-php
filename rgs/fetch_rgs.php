<?php

include '../fetch_data.php';
$query = "select
        stock_grossiste.nom_grossiste_sg,
        stock_grossiste.Produit_sg,
        case when mois = 'janvier' then Qte_sg end as janvier,
        case when mois = 'février' then Qte_sg end as février,
        case when mois = 'mars' then Qte_sg end as mars,
        case when mois = 'avril' then Qte_sg end as avril,
        case when mois = 'mai' then Qte_sg end as mai,
        case when mois = 'juin' then Qte_sg end as juin,
        case when mois = 'juillet' then Qte_sg end as juillet,
        case when mois = 'août' then Qte_sg end as août,
        case when mois = 'septembre' then Qte_sg end as septembre,
        case when mois = 'octobre' then Qte_sg end as octobre,
        case when mois = 'novembre' then Qte_sg end as novembre,
        case when mois = 'décembre' then Qte_sg end as décembre
      from stock_grossiste
      WHERE year(date_stock_sg) = '2021'";

fetch_data($query);
