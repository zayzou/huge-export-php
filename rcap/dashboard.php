<?php
session_start();
include('../db_connect.php');
$type_u = 'admin'; #session variable
$region = ''; #session variable
$region = $type_u == 'admin' ? '' : $region;
$hidden = $type_u == 'admin' ? '' : "hidden";

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="Soffi Zahir" />
    <title>Rapport général</title>
    <!-- <meta http-equiv="Cache-control" content="public"> -->

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--datatables  -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css" />
    <!-- Flatpck -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_green.css" />
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>

    <!-- Custom styles for this template -->
    <link href="../dashboard.css" rel="stylesheet" />
</head>

<body>
    <header class="navbar navbar-light sticky-top flex-md-nowrap p-0 shadow" style="background-color: #e3f2fd">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">MERINAL</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-nav">
            <div class="nav-item text-nowrap">

            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">
                                <span data-feather="home"></span>
                                Dashboard
                            </a>
                        </li>
                    </ul>

                    <h6 class="
                sidebar-heading
                d-flex
                justify-content-between
                align-items-center
                px-3
                mt-4
                mb-1
                text-muted
              ">

                </div>
            </nav>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="
              d-flex
              justify-content-between
              flex-wrap flex-md-nowrap
              align-items-center
              pt-3
              pb-2
              mb-3
              border-bottom
            ">
                    <h1 class="h2">Rapport des Chiffres d'affaires des produits</h1>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control form-control-sm showdate" placeholder="Date 01" id="start_date" />
                            </div>
                            <div class="col">
                                <input type="text" class="form-control form-control-sm showdate" placeholder="Date 02" id="end_date" />
                            </div>
                            <div class="col">
                                <select <?= $hidden ?> name="region_form" class="form-control-sm form-control" id="region" placeholder="Selectionez une Region">
                                    <option value="">Liste des Regions</option>
                                    <option value="Alger">Alger</option>
                                    <option value="Annaba">Annaba</option>
                                    <option value="Chlef">Chlef</option>
                                    <option value="Constantine">Constantine</option>
                                    <option value="Grand Sud">Grand Sud</option>
                                    <option value="Oran">Oran</option>
                                    <option value="Setif">Setif</option>
                                    <option value="Tizi Ouzou">Tizi Ouzou</option>
                                    <option value="Tlemcen">Tlemcen</option>
                                </select>
                            </div>
                            <div class="col">
                                <input hidden>
                                </input>
                            </div>

                        </div>
                        <div class="row" style="margin-top: 0.2rem;">
                            <div class="col">
                                <select name="delegue" class="form-control-sm form-control" id="delegue">
                                    <option value="">Nom délégué</option>
                                    <?php
                                    $query = "SELECT matricule_u,nom_u,prenom_u,statut_u FROM utilisateurs
                                     WHERE   (type_u='delegue' and fonction_u='vp') 
                                     AND statut_u = 'actif' AND region_u LIKE '%" . $region . "%'order by nom_u asc";
                                    $result = getData($query);
                                    foreach ($result as $row) {
                                        echo "<option value=" . $row['matricule'] . ">" . $row['nom_u'] . ' ' . $row['prenom_u'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                <select name="produit" class="form-control-sm form-control" id="produit">
                                    <option value="">Produit</option>
                                    <?php
                                    $query = "SELECT DISTINCT nom_p FROM produits order by nom_p ";
                                    $result = getData($query);
                                    foreach ($result as $row) {
                                        echo "<option value=" . $row['nom_p'] . ">" . $row['nom_p'] . ' ' . $row['prenom_u'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                <button id="search" class="btn btn-sm btn-info" style="color: white">
                                    Rechercher
                                </button>
                            </div>
                            <div class="col">
                                <input hidden>
                                </input>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer" id="export" style="display: none">
                        <small class="text-muted">
                            <button id="btn-export" class="btn btn-sm btn-success" style="color: white">
                                Export to excel
                            </button>
                        </small>
                        <small class="text-muted">
                            <button id="btn-reset" class="btn btn-sm btn-danger" style="color: white">
                                Réinitialiser la recherche
                            </button>
                        </small>
                    </div>
                </div>

                <!-- <div class="container"> -->
                <div class="table-responsive" style="margin-top: 01.125rem">
                    <table id="report_table" class="
                table table-sm table-striped table-bordered
                dt-responsive
                nowrap
              " style="width: 100%" id="rapport01">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>QTE+UG commandé</th>
                                <th>Valeur PVG remisé commandé</th>
                                <th>Total Remise de commandes</th>
                                <th>QTE+UG Facturé</th>
                                <th>Valeur PVG remisé Facturé</th>
                                <th>Total Remise de factures</th>
                                <th>taux de Facturation </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- flatpickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/fr.js"></script>
    <!-- Datatables -->
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>

</body>

<script>
    $(document).ready(function() {
        //init flatpickr
        function initFlatpck() {
            flatpickr.localize(flatpickr.l10ns.fr);
            flatpickr(".showdate")
            $(".showdate").flatpickr({
                defaultDate: "today",
                maxDate: "today",

            });
        }


        function resetComponents() {
            $('#report_table').DataTable().destroy();
            fetch_data('yes', '', '', '');
            initFlatpck();
            $("#export").css({
                "display": "none"
            });
            $("#region").val("");
            $("#delegue").val("");
            $("#produit").val("");
        }
        resetComponents();

        function fetch_data(is_date_search, start_date = '', end_date = '', region = '', produit = '', delegue = '') {
            var dataTable = $('#report_table').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "fetch_rcap.php",
                    type: "POST",
                    data: {
                        is_date_search: is_date_search,
                        start_date: start_date,
                        end_date: end_date,
                        region: region,
                        produit: produit,
                        delegue: delegue
                    }
                }
            });
        }


        $("#search").click(function() {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var region = $('#region').val();
            var produit = $('#produit').val();
            var delegue = $('#delegue').val();
            console.log(start_date + " " + end_date + region);
            if (start_date != "" && end_date != "") {
                $('#report_table').DataTable().destroy();
                fetch_data('yes', start_date, end_date, region, produit, delegue);
                $("#export").css({
                    "display": "block"
                });

            } else {
                alert("Both Date is Required");
            }
        });


        $('#btn-export').click(function() {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var region = $('#region').val();
            var produit = $('#produit').val();
            var delegue = $('#delegue').val();
            console.log(start_date + " " + end_date + " " + region)
            if (start_date != '' && end_date != '') {
                exportData(start_date, end_date, region, produit, delegue);
                resetComponents();
            } else {
                alert("Both Date is Required");
            }
        });
        $('#btn-reset').click(function() {

            resetComponents();

        });

        function exportData(start_date, end_date, region, produit = '', delegue = '') {
            if (start_date != '' && end_date != '') {
                console.log(start_date + " " + end_date)
                <?php $_SESSION['referrer'] = "rcap.php"; ?>
                window.location.href = 'export_rcap.php?start_date=' + start_date + '&end_date=' + end_date + '&region=' + region + '&produit=' + produit + '&delegue=' + delegue;
            } else {
                alert("Both Date is Required");
            }
            console.log('export');
        }
    });
</script>

</html>