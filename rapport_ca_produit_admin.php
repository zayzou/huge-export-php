<?php

include("connexion.php");

if (empty($_SESSION['username'])) {
	header("location: index.php");
}





//----------------------initialisation----------------------------------------------------------------------------------



$periode = 0;



$filter_go = 0;

$filter_go = $_GET['filter'];

if (isset($_GET['dd']) and isset($_GET['df'])) {

	$date_debut_form = $_GET['dd'];

	$date_fin_form = $_GET['df'];

	$periode = 1;
} else {

	$date_debut_form = "2020-01-01";

	$date_fin_form = date("Y-m-d");
}

$product = "";

$select_product = 0;

if (isset($_GET['produit']) and $_GET['produit'] != "") //pauser3

{

	$product = $_GET['produit'];

	$select_product = 1;
}



$delegue = "";

$select_del = 0;

if (isset($_GET['delegue']) and $_GET['delegue'] != "") {

	$delegue = $_GET['delegue'];

	$select_del = 1;
}





$region_admin = "";

$select_reg = 0;

if (isset($_GET['reg']) and $_GET['reg'] != "") {



	$region_admin = $_GET['reg'];

	$select_reg = 1;
}



//---------------------- fin initialisation----------------------------------------------------------------------------------

//----------------------  recherche---------------------------------------------------------------------------------- 



if (isset($_POST['rechercher'])) {

	$date_fin_form = securite::verif_get($_POST['date_fin_form']);

	$date_debut_form = securite::verif_get($_POST['date_debut_form']);

	$produit_form = securite::verif_get($_POST['produit_form']);

	$delegue_form = securite::verif_get($_POST['delegue_form']);

	$region_form = securite::verif_get($_POST['region_form']);

	$filter = 1;

	if (substr($date_fin_form, 4, 1) != "-") {

		//---------------------conversion du format de la date-------------------------';

		$annnee = substr($date_fin_form, 6, 4);

		$mois = substr($date_fin_form, 0, 2);

		$jour = substr($date_fin_form, 3, 2);

		$date_fin_form = $annnee . '-' . $mois . '-' . $jour;
	}

	//--------------------- fin conversion du format de la date-------------------------';

	//---------------------conversion du format de la date-------------------------';

	if (substr($date_debut_form, 4, 1) != "-") {

		$annnee = substr($date_debut_form, 6, 4);

		$mois = substr($date_debut_form, 0, 2);

		$jour = substr($date_debut_form, 3, 2);

		$date_debut_form = $annnee . '-' . $mois . '-' . $jour;

		//--------------------- fin conversion du format de la date-------------------------';

	}



	//----------------------------------- FIN remplir la table des bons--------------------------------------------------------------



?>

	<script>
		document.location.href = "principal.php?p=rapport_ca_produit_admin&dd=<?php echo $date_debut_form; ?>&df=<?php echo $date_fin_form; ?>&produit=<?php echo $produit_form; ?>&delegue=<?php echo $delegue_form; ?>&reg=<?php echo $region_form; ?>&filter=<?php echo $filter; ?>";
	</script>

<?php



}

//---------------------- fin recherche---------------------------------------------------------------------------------- 



//----------------------------------- remplir la table --------------------------------------------------------------

else {

	//$req_sel = "SELECT *  FROM bon_commande WHERE (date_bdc <= ? and date_bdc > ?) ORDER BY region_bdc ASC ";

	$req_sel = "SELECT DISTINCT nom_p FROM produits order by nom_p ";

	$res_sel = $connexion_forum->prepare($req_sel);





	$res_sel->execute();
}

//----------------------------------- FIN remplir la table --------------------------------------------------------------



?>

<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">

<link rel="stylesheet" href="assets/css/neon-core.css">

<link rel="stylesheet" href="assets/js/select2/select2.css">

<script src="assets/js/Chart.js"></script>





<h2>Rapport des Chiffres d'affaires des produits</h2>

<br />

<div class="row">

	<div class="col-md-12">

		<div class="panel panel-primary" data-collapsed="0">

			<div class="panel-body">

				<form role="form" id="form1" method="post" class="validate form-horizontal form-groups-bordered validate">

					<script type="text/javascript">
						jQuery(document).ready(function($) {

							var $table3 = jQuery("#dtHorizontalExample");



							$table3.DataTable({

								"scrollX": true,

								dom: 'Bfrtip',

								buttons: [



									'excelHtml5' //,

									//'csvHtml5',

									//'pdfHtml5'

								]

							});

							$('.dataTables_length').addClass('bs-select');

						});
					</script>

					<div class="form-group">











						<label class=" col-sm-2 control-label">Date de début</label>

						<div class="col-sm-3">

							<input type="text" value="<?php if ($periode == 1) {
															echo $date_debut_form;
														} ?>" id="date_debut" class="form-control datepicker" name="date_debut_form" data-end-date="+0d" data-validate="required" placeholder="Selectionez une date de début">

							<!--touchez pas le champs jj/mm/aaa svp<input class="form-control"  type="date" value="touchez pas ici SVP" data-start-date="-1d" id="example-date-input">-->

						</div>







						<label class="col-sm-2 control-label">Date de Fin </label>

						<div class="col-sm-3">

							<input type="text" value="<?php if ($periode == 1) {
															echo $date_fin_form;
														} ?>" id="date_fin" class="form-control datepicker" name="date_fin_form" data-end-date="+0d" data-validate="required" placeholder="Selectionez une date de fin">

							<!--touchez pas le champs jj/mm/aaa svp<input class="form-control"  type="date" value="touchez pas ici SVP" data-start-date="-1d" id="example-date-input">-->



						</div>







					</div>

					<div class="form-group">

						<label class="col-sm-2 control-label">Region</label>



						<div class="col-sm-3 ">



							<select name="region_form" class="form-control" id="mot_cloner" placeholder="Selectionez une Region">

								<option></option>

								<optgroup label="Liste des Regions" style="padding-bottom:31px !important;">

									<option value="Alger">Alger</option>

									<option value="Annaba">Annaba </option>

									<option value="Chlef">Chlef </option>

									<option value="Constantine">Constantine </option>

									<option value="Grand Sud">Grand Sud </option>

									<option value="Oran">Oran </option>

									<option value="Setif">Setif </option>

									<option value="Tizi Ouzou">Tizi Ouzou </option>

									<option value="Tlemcen">Tlemcen </option>





								</optgroup>

							</select>





						</div>

					</div>

					<div class="form-group">

						<label class="col-sm-2 control-label">Nom délégué</label>



						<div class="col-sm-3">



							<select class="form-control" name="delegue_form">

								<option></option>

								<optgroup label="Liste des délégués">

									<?php  // recupération des tuples --------------------------------------------------------



									// recupération des tuples --------------------------------------------------------



									// recupération des tuples --------------------------------------------------------

									$req_rep_del = "SELECT * FROM utilisateurs where (type_u='delegue' and fonction_u='vp') order by nom_u asc";

									$res_rep_del = $connexion_forum->prepare($req_rep_del);





									$res_rep_del->execute();





									// On affiche chaque entrée une à une

									while ($donnees2 = $res_rep_del->fetch()) {

									?>

										<option value="<?php echo $donnees2['matricule_u']; ?>"><?php echo $donnees2['nom_u'] . ' ' . $donnees2['prenom_u']; ?> </option>

									<?php }



									?>



								</optgroup>

							</select>



						</div>

						<label class="col-sm-2 control-label">Produit</label>



						<div class="col-sm-3 ">



							<select name="produit_form" class="form-control" id="mot_cloner" placeholder="Selectionez un produit">







								<option></option>

								<optgroup label="Liste des Produits" style="padding-bottom:31px !important;">

									<?php  // recupération des tuples --------------------------------------------------------

									$reponse = $connexion_forum->query('SELECT DISTINCT nom_p FROM produits order by nom_p ');

									// On affiche chaque entrée une à une

									while ($donnees = $reponse->fetch()) {

									?>

										<option value="<?php echo $donnees['nom_p']; ?>"><?php echo $donnees['nom_p']; ?></option>

									<?php }
									$reponse->closeCursor(); // Termine le traitement de la requête-------------------------- 
									?>



								</optgroup>

							</select>





						</div>

					</div>

					<div class="form-group">

						<div class="col-sm-offset-5 col-sm-3">

							</br>

							<input type="submit" id="recherche" class="btn btn-success" name="rechercher" value="Rechercher" />

						</div>

					</div>

					<?php

					if ($periode == 1) {

						$req_rep_del2 = "SELECT * FROM utilisateurs where matricule_u=?";

						$res_rep_del2 = $connexion_forum->prepare($req_rep_del2);

						$res_rep_del2->bindParam(1, $delegue);

						$res_rep_del2->execute();





						// On affiche chaque entrée une à une

						while ($donnees = $res_rep_del2->fetch()) {

							$nom_del = $donnees['nom_u'] . " " . $donnees['prenom_u'];
						}

						//---------------------conversion du format de la date-------------------------';

						$a = substr($date_fin_form, 0, 4);

						$m = substr($date_fin_form, 5, 2);

						$j = substr($date_fin_form, 8, 2);

						$date_fin = $j . '-' . $m . '-' . $a;

						//--------------------- fin conversion du format de la date-------------------------';

						//---------------------conversion du format de la date-------------------------';

						$a = substr($date_debut_form, 0, 4);

						$m = substr($date_debut_form, 5, 2);

						$j = substr($date_debut_form, 8, 2);

						$date_debut = $j . '-' . $m . '-' . $a;

						//--------------------- fin conversion du format de la date-------------------------';

						if ($select_del == 1 and $select_product == 1) {



					?>



							<h3 class="col-sm-offset-4">Rapport du <?php echo $date_debut; ?> au <?php echo $date_fin; ?></h3>

							<h3 class="col-sm-offset-3"> <?php echo $nom_del; ?> pour le produit <?php echo $product; ?></h3>



							<?php

						} else if ($select_del == 0 and $select_product == 1) {

							if ($select_reg == 0) {

							?>



								<h3 class="col-sm-offset-4">Rapport du <?php echo $date_debut; ?> au <?php echo $date_fin; ?></h3>

								<h3 class="col-sm-offset-4">Tout les délégués - <?php echo $product; ?></h3>





							<?php

							} else {

							?>

								<h3 class="col-sm-offset-4">Rapport du <?php echo $date_debut; ?> au <?php echo $date_fin; ?></h3>

								<h3 class="col-sm-offset-4">Tout les délégués - <?php echo $product; ?></h3>

								<h3 class="col-sm-offset-4">Region : <?php echo $region_admin; ?></h3>



							<?php

							}
						} else if ($select_del == 1 and $select_product == 0) {

							?>



							<h3 class="col-sm-offset-4">Rapport du <?php echo $date_debut; ?> au <?php echo $date_fin; ?></h3>

							<h3 class="col-sm-offset-4"><?php echo $nom_del; ?> - tout les produits</h3>



							<?php

						} else if ($select_del == 0 and $select_product == 0) {

							if ($select_reg == 0) {

							?>



								<h3 class="col-sm-offset-4">Rapport globale des produits</h3>

								<h3 class="col-sm-offset-4">du <?php echo $date_debut; ?> au <?php echo $date_fin; ?></h3>





							<?php

							} else {

							?>

								<h3 class="col-sm-offset-4">Rapport globale des produits</h3>

								<h3 class="col-sm-offset-4">Region : <?php echo $region_admin; ?></h3>

								<h3 class="col-sm-offset-4">du <?php echo $date_debut; ?> au <?php echo $date_fin; ?></h3>



							<?php

							}

							?>









						<?php

						}
					} else {

						?>

						<h3 class="col-sm-offset-4">Rapport globale des produits </h3>



					<?php

					}

					?>



					<div class="form-group">

						<div id="table-4_wrapper" class="dataTables_wrapper">



							<table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">

								<thead>

									<tr role="row">

										<th class="sorting_asc" tabindex="0" aria-controls="table-4" rowspan="1" colspan="1" style="width: 5% important!;" aria-sort="ascending" aria-label="N° BDC: activate to sort column descending">Produit</th>

										<th class="sorting" tabindex="0" aria-controls="table-4" rowspan="1" colspan="1" style="width: 10% important!;" aria-label="Engine version: activate to sort column ascending">QTE+UG commandé</th>

										<th class="sorting" tabindex="0" aria-controls="table-4" rowspan="1" colspan="1" style="width: 10% important!;" aria-label="Browser: activate to sort column ascending">Valeur PVG remisé commandé</th>

										<th class="sorting" tabindex="0" aria-controls="table-4" rowspan="1" colspan="1" style="width: 10% important!;" aria-label="Browser: activate to sort column ascending">Total Remise de commandes</th>

										<th class="sorting" tabindex="0" aria-controls="table-4" rowspan="1" colspan="1" style="width: 10% important!;" aria-label="Engine version: activate to sort column ascending">QTE+UG Facturé</th>

										<th class="sorting" tabindex="0" aria-controls="table-4" rowspan="1" colspan="1" style="width: 10% important!;" aria-label="Engine version: activate to sort column ascending">Valeur PVG remisé Facturé</th>

										<th class="sorting" tabindex="0" aria-controls="table-4" rowspan="1" colspan="1" style="width: 10% important!;" aria-label="Browser: activate to sort column ascending">Total Remise de factures</th>

										<th class="sorting" tabindex="0" aria-controls="table-4" rowspan="1" colspan="1" style="width: 20% important!;" aria-label="Engine version: activate to sort column ascending">taux de Facturation </th>











								</thead>

								<tbody>

									<?php

									//----------------------------------- remplir la table des assistantes--------------------------------------------------------------

									if ($select_del == 1 and $select_product == 1) //pauser

									{



										while ($row_sel = $res_sel->fetch()) {

											$produit = $row_sel['nom_p'];



											$req_rep2 = "SELECT * FROM ligne_commande WHERE produit_lc =? and numbdc_lc in (select num_bdc from bon_commande where nom_delegue_action =? and statut_bdc!='Annule' and(date_bdc <=? and date_bdc >=?))";

											$res_rep2 = $connexion_forum->prepare($req_rep2);

											$res_rep2->bindParam(1, $product);

											$res_rep2->bindParam(2, $delegue);

											$res_rep2->bindParam(3, $date_fin_form);

											$res_rep2->bindParam(4, $date_debut_form);



											$res_rep2->execute();

											$total_valeure_bon = 0;

											$total_valeure_facture = 0;

											$total_qteug_bon = 0;

											$total_qteug_facture = 0;

											$total_remise_facture = 0;

											$total_remise_produit = 0;

											$percent_validation = 0;

											while ($row_sel2 = $res_rep2->fetch()) {

												$valeure_bon = $row_sel2['valeure_lc'];

												$valeure_facture = $row_sel2['valeure_facture_lc'];

												$qteug_bon = $row_sel2['qteug_lc'];

												$qteug_facture = $row_sel2['qteug_facture_lc'];

												$remise_facture_lc = $row_sel2['remise_facture_lc'];

												$remise_produit_lc = $row_sel2['remise_produit_lc'];

												$validation_produit = $row_sel2['validation_produit'];



												if ($validation_produit == "1") {

													$total_valeure_facture = $total_valeure_facture + $valeure_facture;

													$total_remise_facture = $total_remise_facture + $remise_facture_lc;

													$total_qteug_facture = $total_qteug_facture + $qteug_facture;
												}

												$total_valeure_bon = $total_valeure_bon + $valeure_bon;

												$total_qteug_bon = $total_qteug_bon + $qteug_bon;

												$total_remise_produit = $total_remise_produit + $remise_produit_lc;

												$percent_validation = ($total_valeure_facture / $total_valeure_bon) * 100;
											} //fin while 2



											if ($produit == $product) {



									?>

												<tr>

													<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:left;"><?php echo $produit; ?></td>

													<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($total_qteug_bon, 2); ?></td>

													<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($total_valeure_bon, 2); ?></td>

													<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($total_remise_produit, 2); ?></td>

													<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($total_qteug_facture, 2); ?></td>

													<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($total_valeure_facture, 2); ?></td>

													<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($total_remise_facture, 2); ?></td>

													<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($percent_validation, 2) . "%"; ?></td>

												</tr>

											<?php

											}
										} // fin while 1

									} // fin if select del



									else if ($select_del == 1 and $select_product == 0) //done

									{



										while ($row_sel = $res_sel->fetch()) {

											$produit = $row_sel['nom_p'];



											$req_rep2 = "SELECT * FROM ligne_commande WHERE produit_lc =? and numbdc_lc in (select num_bdc from bon_commande where nom_delegue_action =? and statut_bdc!='Annule' and (date_bdc <=? and date_bdc >=?))";

											$res_rep2 = $connexion_forum->prepare($req_rep2);

											$res_rep2->bindParam(1, $produit);

											$res_rep2->bindParam(2, $delegue);

											$res_rep2->bindParam(3, $date_fin_form);

											$res_rep2->bindParam(4, $date_debut_form);





											$res_rep2->execute();

											$total_valeure_bon = 0;

											$total_valeure_facture = 0;

											$total_qteug_bon = 0;

											$total_qteug_facture = 0;

											$total_remise_facture = 0;

											$total_remise_produit = 0;

											$percent_validation = 0;

											while ($row_sel2 = $res_rep2->fetch()) {

												$valeure_bon = $row_sel2['valeure_lc'];

												$valeure_facture = $row_sel2['valeure_facture_lc'];

												$qteug_bon = $row_sel2['qteug_lc'];

												$qteug_facture = $row_sel2['qteug_facture_lc'];

												$remise_facture_lc = $row_sel2['remise_facture_lc'];

												$remise_produit_lc = $row_sel2['remise_produit_lc'];

												$validation_produit = $row_sel2['validation_produit'];



												if ($validation_produit == "1") {

													$total_valeure_facture = $total_valeure_facture + $valeure_facture;

													$total_remise_facture = $total_remise_facture + $remise_facture_lc;

													$total_qteug_facture = $total_qteug_facture + $qteug_facture;
												}

												$total_valeure_bon = $total_valeure_bon + $valeure_bon;

												$total_qteug_bon = $total_qteug_bon + $qteug_bon;

												$total_remise_produit = $total_remise_produit + $remise_produit_lc;

												$percent_validation = ($total_valeure_facture / $total_valeure_bon) * 100;
											} //fin while 2







											?>

											<tr>

												<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:left;"><?php echo $produit; ?></td>

												<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($total_qteug_bon, 2); ?></td>

												<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($total_valeure_bon, 2); ?></td>

												<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($total_remise_produit, 2); ?></td>

												<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($total_qteug_facture, 2); ?></td>

												<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($total_valeure_facture, 2); ?></td>

												<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($total_remise_facture, 2); ?></td>

												<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($percent_validation, 2) . "%"; ?></td>

											</tr>

											<?php

										} // fin while 1



									} //fin else if 1

									else if ($select_del == 0 and $select_product == 1) //done

									{





										while ($row_sel = $res_sel->fetch()) {



											$produit = $row_sel['nom_p'];

											if ($select_reg == 0) {

												$req_rep2 = "SELECT * FROM ligne_commande WHERE produit_lc =? and numbdc_lc in (select num_bdc from bon_commande where statut_bdc!='Annule' and(date_bdc <=? and date_bdc >=?) )";

												$res_rep2 = $connexion_forum->prepare($req_rep2);

												$res_rep2->bindParam(1, $product);

												$res_rep2->bindParam(2, $date_fin_form);

												$res_rep2->bindParam(3, $date_debut_form);
											} else {

												$req_rep2 = "SELECT * FROM ligne_commande WHERE produit_lc =? and numbdc_lc in (select num_bdc from bon_commande where (date_bdc <=? and date_bdc >=?)and  region_bdc=? and statut_bdc!='Annule' )";

												$res_rep2 = $connexion_forum->prepare($req_rep2);

												$res_rep2->bindParam(1, $product);

												$res_rep2->bindParam(2, $date_fin_form);

												$res_rep2->bindParam(3, $date_debut_form);

												$res_rep2->bindParam(4, $region_admin);
											}



											$res_rep2->execute();

											$total_valeure_bon = 0;

											$total_valeure_facture = 0;

											$total_qteug_bon = 0;

											$total_qteug_facture = 0;

											$total_remise_facture = 0;

											$total_remise_produit = 0;

											$percent_validation = 0;

											while ($row_sel2 = $res_rep2->fetch()) {

												$valeure_bon = $row_sel2['valeure_lc'];

												$valeure_facture = $row_sel2['valeure_facture_lc'];

												$qteug_bon = $row_sel2['qteug_lc'];

												$qteug_facture = $row_sel2['qteug_facture_lc'];

												$remise_facture_lc = $row_sel2['remise_facture_lc'];

												$remise_produit_lc = $row_sel2['remise_produit_lc'];

												$validation_produit = $row_sel2['validation_produit'];



												if ($validation_produit == "1") {

													$total_valeure_facture = $total_valeure_facture + $valeure_facture;

													$total_remise_facture = $total_remise_facture + $remise_facture_lc;

													$total_qteug_facture = $total_qteug_facture + $qteug_facture;
												}

												$total_valeure_bon = $total_valeure_bon + $valeure_bon;

												$total_qteug_bon = $total_qteug_bon + $qteug_bon;

												$total_remise_produit = $total_remise_produit + $remise_produit_lc;

												$percent_validation = ($total_valeure_facture / $total_valeure_bon) * 100;
											} //fin while 2

											$product2 = $product;

											if ($produit == $product2) {



											?>

												<tr>

													<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:left;"><?php echo $produit; ?></td>

													<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($total_qteug_bon, 2); ?></td>

													<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($total_valeure_bon, 2); ?></td>

													<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($total_remise_produit, 2); ?></td>

													<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($total_qteug_facture, 2); ?></td>

													<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($total_valeure_facture, 2); ?></td>

													<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($total_remise_facture, 2); ?></td>

													<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($percent_validation, 2) . "%"; ?></td>

												</tr>

											<?php

											}
										} // fin while 1



									} //fin else if 2

									else if ($select_del == 0 and $select_product == 0 and $filter_go == 1) //done

									{



										while ($row_sel = $res_sel->fetch()) {



											$produit = $row_sel['nom_p'];

											if ($select_reg == 0) {

												$req_rep2 = "SELECT * FROM ligne_commande WHERE numbdc_lc in (select num_bdc from bon_commande where  (date_bdc <=? and date_bdc >=?)and statut_bdc!='Annule')";

												$res_rep2 = $connexion_forum->prepare($req_rep2);

												$res_rep2->bindParam(1, $date_fin_form);

												$res_rep2->bindParam(2, $date_debut_form);
											} else {

												$req_rep2 = "SELECT * FROM ligne_commande WHERE numbdc_lc in (select num_bdc from bon_commande where  (date_bdc <=? and date_bdc >=?) and region_bdc=? and statut_bdc!='Annule')";

												$res_rep2 = $connexion_forum->prepare($req_rep2);

												$res_rep2->bindParam(1, $date_fin_form);

												$res_rep2->bindParam(2, $date_debut_form);

												$res_rep2->bindParam(3, $region_admin);
											}







											$res_rep2->execute();

											$total_valeure_bon = 0;

											$total_valeure_facture = 0;

											$total_qteug_bon = 0;

											$total_qteug_facture = 0;

											$total_remise_facture = 0;

											$total_remise_produit = 0;

											$percent_validation = 0;

											while ($row_sel2 = $res_rep2->fetch()) {

												$valeure_bon = $row_sel2['valeure_lc'];

												$valeure_facture = $row_sel2['valeure_facture_lc'];

												$qteug_bon = $row_sel2['qteug_lc'];

												$qteug_facture = $row_sel2['qteug_facture_lc'];

												$remise_facture_lc = $row_sel2['remise_facture_lc'];

												$remise_produit_lc = $row_sel2['remise_produit_lc'];

												$validation_produit = $row_sel2['validation_produit'];



												$produit2 = $row_sel2['produit_lc'];



												if ($produit == $produit2) {

													if ($validation_produit == "1") {

														$total_valeure_facture = $total_valeure_facture + $valeure_facture;

														$total_remise_facture = $total_remise_facture + $remise_facture_lc;

														$total_qteug_facture = $total_qteug_facture + $qteug_facture;
													}

													$total_valeure_bon = $total_valeure_bon + $valeure_bon;



													$total_qteug_bon = $total_qteug_bon + $qteug_bon;

													$total_remise_produit = $total_remise_produit + $remise_produit_lc;



													$percent_validation = ($total_valeure_facture / $total_valeure_bon) * 100;
												}
											} //fin while 2







											?>

											<tr>

												<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:left;"><?php echo $produit; ?></td>

												<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($total_qteug_bon, 2); ?></td>

												<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($total_valeure_bon, 2); ?></td>

												<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($total_remise_produit, 2); ?></td>

												<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($total_qteug_facture, 2); ?></td>

												<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($total_valeure_facture, 2); ?></td>

												<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($total_remise_facture, 2); ?></td>

												<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($percent_validation, 2) . "%"; ?></td>

											</tr>

									<?php



										} // fin while 1

									} // fin if select del

									?>











								</tbody>



							</table>





				</form>

			</div>

		</div>

		<!--div class="col-sm-6" style="width:50%; !important;">

	 

			<canvas id="myChart" ></canvas>

			</div-->

	</div>

</div>

</div>

</div>



<link rel="stylesheet" href="assets/js/datatables/datatables.css">

<link rel="stylesheet" href="assets/js/datatables/scroll.css">

<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">

<link rel="stylesheet" href="assets/css/bootstrap.css">

<link rel="stylesheet" href="assets/js/select2/select2.css">



<script src="assets/js/datatables/datatables.js"></script>

<!--script src="assets/js/jquery-1.11.3.min.js"></script-->

<script src="assets/js/select2/select2.min.js"></script>

<script src="assets/js/neon-chat.js"></script>

<script>
	var ctx = document.getElementById('myChart').getContext('2d');

	var myChart = new Chart(ctx, {

		type: 'bar', //horizontalBar  bar line pie

		data: {

			labels: ['Alger', 'Annaba', 'Constantine', 'Tizi Ouzou', 'Setif', 'Oran', 'Chlef', 'Tlemcen', 'Grand Sud'],

			datasets: [{

				label: 'Nombres de bons',







				data: [<?php echo $total_Alger; ?>, <?php echo $total_Annaba; ?>, <?php echo $total_Constantine; ?>, <?php echo $total_Tizi; ?>, <?php echo $total_Setif; ?>,

					<?php echo $total_Oran; ?>, <?php echo $total_Chlef; ?>, <?php echo $total_Tlemcen; ?>, <?php echo $total_Sud; ?>,
				],

				backgroundColor: [

					'rgba(245, 28, 3, 0.4)',

					'rgba(54, 162, 235, 0.4)',

					'rgba(255, 206, 86, 0.4)',

					'rgba(224, 204, 24, 0.4)',

					'rgba(153, 102, 255, 0.4)',

					'rgba(62, 230, 19, 0.4)',

					'rgba(128, 0, 64, 0.4)',

					'rgba(128, 64, 0, 0.4)',

					'rgba(39, 190, 168, 0.4)'

				],

				borderColor: [

					'rgba(245, 28, 3, 1)',

					'rgba(54, 162, 235, 1)',

					'rgba(255, 206, 86, 1)',

					'rgba(224, 204, 24, 1)',

					'rgba(153, 102, 255, 1)',

					'rgba(62, 230, 19, 1)',

					'rgba(128, 0, 64, 1)',

					'rgba(128, 64, 0, 1)',

					'rgba(39, 190, 168, 1)'

				],

				borderWidth: 1

			}]

		},

		options: {

			scales: {

				yAxes: [{



					ticks: {

						beginAtZero: true



					}



				}]

			}

		}

	});
</script>