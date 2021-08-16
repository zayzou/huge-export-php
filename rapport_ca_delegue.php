<?php

include("connexion.php");

if (empty($_SESSION['username'])) {
	header("location: index.php");
}





//----------------------initialisation----------------------------------------------------------------------------------





$filter_go = 0;

$filter_go = $_GET['filter'];

if (isset($_GET['dd']) and isset($_GET['df'])) {

	$date_debut_form = $_GET['dd'];

	$date_fin_form = $_GET['df'];

	$periode = 1;
} else {

	$debutdate = date("Y");

	$date_debut_form = $debutdate . "-01-01";

	$date_fin_form = date("Y-m-d");

	$periode = 1;
}





$delegue = "";

$select_del = 0;

if (isset($_GET['delegue']) and $_GET['delegue'] != "") {

	$delegue = $_GET['delegue'];

	$select_del = 1;
}





$region_admin = $region_session;

$select_reg = 1;





//---------------------- fin initialisation----------------------------------------------------------------------------------

//----------------------  recherche---------------------------------------------------------------------------------- 



if (isset($_POST['rechercher'])) {

	$date_fin_form = securite::verif_get($_POST['date_fin_form']);

	$date_debut_form = securite::verif_get($_POST['date_debut_form']);



	$delegue_form = securite::verif_get($_POST['delegue_form']);



	$filter = 1;

	if (substr($date_fin_form, 4, 1) != "-") {

		//---------------------conversion du format de la date-------------------------';

		$annnee = substr($date_fin_form, 6, 4);

		$mois = substr($date_fin_form, 0, 2);

		$jour = substr($date_fin_form, 3, 2);

		$date_fin_form = $annnee . '-' . $mois . '-' . $jour;

		//--------------------- fin conversion du format de la date-------------------------';

	}

	if (substr($date_debut_form, 4, 1) != "-") {

		//---------------------conversion du format de la date-------------------------';

		$annnee = substr($date_debut_form, 6, 4);

		$mois = substr($date_debut_form, 0, 2);

		$jour = substr($date_debut_form, 3, 2);

		$date_debut_form = $annnee . '-' . $mois . '-' . $jour;

		//--------------------- fin conversion du format de la date-------------------------';

	}



	//----------------------------------- FIN remplir la table des bons--------------------------------------------------------------



?>

	<script>
		document.location.href = "principal.php?p=rapport_ca_delegue&dd=<?php echo $date_debut_form; ?>&df=<?php echo $date_fin_form; ?>&delegue=<?php echo $delegue_form; ?>&filter=<?php echo $filter; ?>";
	</script>

<?php



}

//---------------------- fin recherche---------------------------------------------------------------------------------- 



//----------------------------------- remplir la table --------------------------------------------------------------

else {



	$req_sel = "SELECT * FROM utilisateurs where  (fonction_u='vp' or fonction_u='vm') and region_u=? ";

	$res_sel = $connexion_forum->prepare($req_sel);

	$res_sel->bindParam(1, $region_admin);





	$res_sel->execute();
}

//----------------------------------- FIN remplir la table --------------------------------------------------------------



?>





<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">

<link rel="stylesheet" href="assets/css/neon-core.css">

<link rel="stylesheet" href="assets/js/select2/select2.css">

<script src="assets/js/Chart.js"></script>





<h2>Rapport des Chiffres d'affaires des délégués</h2>

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

						</div>







						<label class="col-sm-2 control-label">Date de Fin </label>

						<div class="col-sm-3">

							<input type="text" value="<?php if ($periode == 1) {
															echo $date_fin_form;
														} ?>" id="date_fin" class="form-control datepicker" name="date_fin_form" data-end-date="+0d" data-validate="required" placeholder="Selectionez une date de fin">



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

									$req_rep_del = "SELECT * FROM utilisateurs where  region_u=?  and (fonction_u='vp' or fonction_u='vm')  ORDER BY `utilisateurs`.`nom_u` ASC ";

									$res_rep_del = $connexion_forum->prepare($req_rep_del);

									$res_rep_del->bindParam(1, $region_admin);



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



					</div>

					<div class="form-group">

						<div class="col-sm-offset-5 col-sm-3">

							</br>

							<input type="submit" id="recherche" class="btn btn-success" name="rechercher" value="Rechercher" />

						</div>

					</div>

					<?php

					if ($periode == 1 and $filter_go == 1) {

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

						if ($select_del == 1) {



					?>



							<h3 class="col-sm-offset-4">Rapport du <?php echo $date_debut; ?> au <?php echo $date_fin; ?></h3>

							<h3 class="col-sm-offset-4"> CA -<?php echo $nom_del; ?> </h3>



							<?php

						} else {

							if ($select_reg == 0) {

							?>



								<h3 class="col-sm-offset-3">Rapport globale des Délégués du <?php echo $date_debut; ?> au <?php echo $date_fin; ?></h3>





							<?php

							} else {

							?>

								<h3 class="col-sm-offset-4">Rapport du <?php echo $date_debut; ?> au <?php echo $date_fin; ?></h3>

								<h3 class="col-sm-offset-4">Délégués de la région <?php echo $region_admin; ?></h3>





						<?php

							}
						}
					} else {

						?>

						<h3 class="col-sm-offset-4">Rapport globale des Délégués </h3>



					<?php

					}

					?>



					<div class="form-group">

						<div id="table-4_wrapper" class="dataTables_wrapper">



							<table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">

								<thead>

									<tr role="row">

										<th class="sorting_asc" tabindex="0" aria-controls="table-4" rowspan="1" colspan="1" style="width: 5% important!;" aria-sort="ascending" aria-label="N° BDC: activate to sort column descending">Nom et prénom</th>

										<th class="sorting" tabindex="0" aria-controls="table-4" rowspan="1" colspan="1" style="width: 10% important!;" aria-label="Engine version: activate to sort column ascending">CA BDC</th>

										<th class="sorting" tabindex="0" aria-controls="table-4" rowspan="1" colspan="1" style="width: 10% important!;" aria-label="Engine version: activate to sort column ascending">CA Validé</th>

										<th class="sorting" tabindex="0" aria-controls="table-4" rowspan="1" colspan="1" style="width: 20% important!;" aria-label="Engine version: activate to sort column ascending">Taux de validation </th>

										<th class="sorting" tabindex="0" aria-controls="table-4" rowspan="1" colspan="1" style="width: 20% important!;" aria-label="Engine version: activate to sort column ascending">Nombre de bons </th>











								</thead>

								<tbody>

									<?php

									//----------------------------------- remplir la table des assistantes--------------------------------------------------------------

									if ($select_del == 1) //pauser

									{

										$req_sel3 = "SELECT * FROM utilisateurs where  matricule_u=? ";

										$res_sel3 = $connexion_forum->prepare($req_sel3);

										$res_sel3->bindParam(1, $delegue);

										$res_sel3->execute();

										while ($row_sel3 = $res_sel3->fetch()) {

											$matricule_deleg = $row_sel3['matricule_u'];

											$nom_deleg = $row_sel3['nom_u'];

											$prenom_deleg = $row_sel3['prenom_u'];

											//-------------------- count bon 

											$req_bon = "select num_bdc from bon_commande where nom_delegue_action =? and (date_bdc <=? and date_bdc >=?) and statut_bdc!='Annule'";

											$res_bon = $connexion_forum->prepare($req_bon);

											$res_bon->bindParam(1, $delegue);

											$res_bon->bindParam(2, $date_fin_form);

											$res_bon->bindParam(3, $date_debut_form);



											$res_bon->execute();

											$existe = $res_bon->rowCount();



											//------------------------------- fin count bons

											$req_rep2 = "SELECT * FROM ligne_commande  where numbdc_lc in (select num_bdc from bon_commande where nom_delegue_action =? and (date_bdc <=? and date_bdc >=?) and statut_bdc!='Annule' )";

											$res_rep2 = $connexion_forum->prepare($req_rep2);



											$res_rep2->bindParam(1, $matricule_deleg);

											$res_rep2->bindParam(2, $date_fin_form);

											$res_rep2->bindParam(3, $date_debut_form);



											$res_rep2->execute();

											$total_valeure_bon = 0;

											$total_valeure_facture = 0;



											$percent_validation = 0;

											while ($row_sel2 = $res_rep2->fetch()) {

												$valeure_bon = $row_sel2['valeure_lc'];

												if ($row_sel2['validation_produit'] == "1") {

													$valeure_facture = $row_sel2['valeure_facture_lc'];
												} else {

													$valeure_facture = 0;
												}





												$total_valeure_bon = $total_valeure_bon + $valeure_bon;

												$total_valeure_facture = $total_valeure_facture + $valeure_facture;

												$percent_validation = ($total_valeure_facture / $total_valeure_bon) * 100;
											} //fin while 2

											//*********************************************** get values *********************



											//*********************************************** fin get values *********************



											if ($matricule_deleg == $delegue) {







									?>

												<tr>

													<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:left;"><?php echo $nom_deleg . " " . $prenom_deleg; ?></td>

													<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo number_format($total_valeure_bon, 2, ".", " "); ?></td>

													<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo number_format($total_valeure_facture, 2, ".", " "); ?></td>

													<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($percent_validation, 2) . "%"; ?></td>

													<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo $existe; ?></td>

												</tr>

											<?php

											}
										} // fin while 1

									} // fin if select del



									else if ($filter_go == 1) {



										while ($row_sel = $res_sel->fetch()) {

											$matricule_deleg = $row_sel['matricule_u'];

											$nom_deleg = $row_sel['nom_u'];

											$prenom_deleg = $row_sel['prenom_u'];

											//-------------------- count bon 

											$req_bon = "select num_bdc from bon_commande where nom_delegue_action =? and (date_bdc <=? and date_bdc >=?) and statut_bdc!='Annule'";

											$res_bon = $connexion_forum->prepare($req_bon);

											$res_bon->bindParam(1, $matricule_deleg);

											$res_bon->bindParam(2, $date_fin_form);

											$res_bon->bindParam(3, $date_debut_form);



											$res_bon->execute();

											$existe = $res_bon->rowCount();



											//------------------------------- fin count bons

											if ($select_reg == 0) {

												$req_rep2 = "SELECT * FROM ligne_commande  where numbdc_lc in (select num_bdc from bon_commande where nom_delegue_action =? and (date_bdc <=? and date_bdc >=?) and statut_bdc!='Annule')";

												$res_rep2 = $connexion_forum->prepare($req_rep2);



												$res_rep2->bindParam(1, $matricule_deleg);

												$res_rep2->bindParam(2, $date_fin_form);

												$res_rep2->bindParam(3, $date_debut_form);
											} else {

												$req_rep2 = "SELECT * FROM ligne_commande  where numbdc_lc in (select num_bdc from bon_commande where nom_delegue_action =? and (date_bdc <=? and date_bdc >=?) and region_bdc=? and statut_bdc!='Annule')";

												$res_rep2 = $connexion_forum->prepare($req_rep2);



												$res_rep2->bindParam(1, $matricule_deleg);

												$res_rep2->bindParam(2, $date_fin_form);

												$res_rep2->bindParam(3, $date_debut_form);

												$res_rep2->bindParam(4, $region_admin);
											}





											$res_rep2->execute();

											$total_valeure_bon = 0;

											$total_valeure_facture = 0;



											$percent_validation = 0;

											while ($row_sel2 = $res_rep2->fetch()) {

												$valeure_bon = $row_sel2['valeure_lc'];

												if ($row_sel2['validation_produit'] == "1") {

													$valeure_facture = $row_sel2['valeure_facture_lc'];
												} else {

													$valeure_facture = 0;
												}





												$total_valeure_bon = $total_valeure_bon + $valeure_bon;

												$total_valeure_facture = $total_valeure_facture + $valeure_facture;

												$percent_validation = ($total_valeure_facture / $total_valeure_bon) * 100;
											} //fin while 2

											//*********************************************** get values *********************



											//*********************************************** fin get values *********************	

											if ($total_valeure_bon > 0) {



											?>

												<tr>

													<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:left;"><?php echo $nom_deleg . " " . $prenom_deleg; ?></td>

													<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo number_format($total_valeure_bon, 2, ".", " "); ?></td>

													<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo number_format($total_valeure_facture, 2, ".", " "); ?></td>

													<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo round($percent_validation, 2) . "%"; ?></td>

													<td class="tdFacture" style="background: #FFFFFF;border: 2px solid #ebebeb; padding : 5px;text-align:center;"><?php echo $existe; ?></td>

												</tr>

									<?php

											} //fin if 0

										} // fin while 1

									} // fin if select del

									?>











								</tbody>



							</table>





				</form>

			</div>

			<!--

	<div class="col-sm-6" style="width:50%; !important;">

	<label class=" col-sm-6 control-label" style="font-size:17px; !important;">Graph CA-Bon de commandes</label>

	</br>

	</br>

	 			<canvas id="myChart" ></canvas>



	</div>

	<div class="col-sm-6" style="width:50%; !important;">

	<label class=" col-sm-6 control-label" style="font-size:17px; !important;">Graph CA-facturation</label>

	</br>

	</br>

	 			<canvas id="myChart2" ></canvas>



	</div>

	-->

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

	//alert("alert:".region)

	//if (region=="Alger")

	//{

	var myChart = new Chart(ctx, {

		type: 'pie', //horizontalBar  bar line pie    

		data: {

			labels: ['Smail', 'ALLOUCHE', 'MEKIMENE', 'CHERIFI', 'ALIOUANE', 'BENSABEUR', 'GACEM', 'BR Alger'],

			datasets: [{

				label: 'Nombres de bons',







				data: [<?php echo $val_smail; ?>, <?php echo $val_allouche; ?>, <?php echo $val_mekimene; ?>, <?php echo $val_cherifi; ?>, <?php echo $val_aliouane; ?>,

					<?php echo $val_bensabeur; ?>, <?php echo $val_gacem; ?>, <?php echo $val_bralger; ?>,
				],

				backgroundColor: [

					'rgba(245, 28, 3, 0.4)',

					'rgba(54, 162, 235, 0.4)',

					'rgba(255, 206, 86, 0.4)',

					'rgba(224, 204, 24, 0.4)',

					'rgba(153, 102, 255, 0.4)',

					'rgba(62, 230, 19, 0.4)',

					'rgba(128, 0, 64, 0.4)',



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

	//}

	//************************************************************************* chart facture

	var ctx = document.getElementById('myChart2').getContext('2d');

	//alert("alert:".region)

	//if (region=="Alger")

	//{

	var myChart = new Chart(ctx, {

		type: 'pie', //horizontalBar  bar line pie    

		data: {

			labels: ['Smail', 'ALLOUCHE', 'MEKIMENE', 'CHERIFI', 'ALIOUANE', 'BENSABEUR', 'GACEM', 'BR Alger'],

			datasets: [{

				label: 'Nombres de bons',







				data: [<?php echo $val_smail_fac; ?>, <?php echo $val_allouche_fac; ?>, <?php echo $val_mekimene_fac; ?>, <?php echo $val_cherifi_fac; ?>, <?php echo $val_aliouane_fac; ?>,

					<?php echo $val_bensabeur_fac; ?>, <?php echo $val_gacem_fac; ?>, <?php echo $val_bralger_fac; ?>,
				],

				backgroundColor: [

					'rgba(245, 28, 3, 0.4)',

					'rgba(54, 162, 235, 0.4)',

					'rgba(255, 206, 86, 0.4)',

					'rgba(224, 204, 24, 0.4)',

					'rgba(153, 102, 255, 0.4)',

					'rgba(62, 230, 19, 0.4)',

					'rgba(128, 0, 64, 0.4)',



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

	//}
</script>