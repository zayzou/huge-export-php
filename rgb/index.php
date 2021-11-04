<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content=""/>
    <meta name="author" content="Soffi Zahir"/>
    <title>Rapport général des bons de commandes</title>
    <meta http-equiv="Cache-Control" content="public">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--datatables  -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css"/>
    <!-- Flatpck -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_green.css"/>
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
    <link href="../dashboard.css" rel="stylesheet"/>
</head>

<body>
<header class="navbar navbar-light sticky-top flex-md-nowrap p-0 shadow" style="background-color: #e3f2fd">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">MERINAL</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <!-- <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search" /> -->
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
                        <a class="nav-link active" aria-current="page" href="../principal.php?p=acceuil">
                            <span data-feather="home"></span>
                            Retour
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
                <h1 class="h2">Rapport général des bons de commandes</h1>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control form-control-sm showdate" placeholder="Date 01"
                                   id="start_date"/>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control form-control-sm showdate" placeholder="Date 02"
                                   id="end_date"/>
                        </div>
                        <div class="col">
                            <select name="region_form" class="form-control-sm form-control" id="region"
                                    placeholder="Selectionez une Region">
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
                            <button id="search" class="btn btn-sm btn-info" style="color: white">
                                Rechercher
                            </button>

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
                        <th>N° BDC</th>
                        <th>Statut</th>
                        <th>Région</th>
                        <th>Nom délégué action</th>
                        <th>Matricule délégué action</th>
                        <th>Date</th>
                        <th>Grossiste</th>
                        <th>Matricule pharmacie</th>
                        <th>Nom Pharmacie</th>
                        <th>Wilaya</th>
                        <th>Total pvg remisé</th>
                        <th>Type</th>
                        <th>Remise du bon</th>
                        <th>Remise facture</th>
                        <th>Date de creation</th>
                        <th>Date de validation</th> <?php //--?>
                        <th>Commentaire</th>
                        <th>Code_produit</th>
                        <th>Nom_produit</th>
                        <th>Qte_bon</th>
                        <th>Ug_bon</th>
                        <th>QteUg_bon</th>
                        <th>PVG_bon</th>
                        <th>PvgUg_bon</th>
                        <th>Valeure_bon</th>
                        <th>Poid_bon</th>
                        <th>Remise_produit</th>
                        <th>Qte_facture</th>
                        <th>QteUg_facture</th>
                        <th>Valeure_facture</th>
                        <th>Remise_facture</th>
                        <th>Poid_facture</th>
                        <th>Liste_produit</th>
                        <th>palier Bon</th>
                        <th>palier Facture</th>
                        <th>Observation</th>
                        <th>Validation_produit</th>

                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<!-- jquery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<!-- flatpickr -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/fr.js"></script>
<!-- Datatables -->
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>

</body>

<script>
    $(document).ready(function () {
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
        }

        resetComponents();


        function fetch_data(is_date_search, start_date = '', end_date = '', region = '') {
            var dataTable = $('#report_table').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "fetch_rgb.php",
                    type: "POST",
                    data: {
                        is_date_search: is_date_search,
                        start_date: start_date,
                        end_date: end_date,
                        region: region
                    }
                }
            });
        }


        $("#search").click(function () {
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();
            var region = $("#region").val();
            console.log(start_date + " " + end_date + region);
            if (start_date != "" && end_date != "") {
                $('#report_table').DataTable().destroy();
                fetch_data('yes', start_date, end_date, region);
                $("#export").css({
                    "display": "block"
                });

            } else {
                alert("Both Date is Required");
            }
        });


        $('#btn-export').click(function () {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var region = $('#region').val();
            console.log(start_date + " " + end_date + " " + region)
            if (start_date != '' && end_date != '') {
                exportData(start_date, end_date, region);
                resetComponents();
            } else {
                alert("Both Date is Required");
            }
        });
        $('#btn-reset').click(function () {
            resetComponents();
        });

        function exportData(start_date, end_date, region) {
            if (start_date != '' && end_date != '') {
                console.log(start_date + " " + end_date)
                <?php $_SESSION['referrer'] = "rgb"; ?>
                window.location.href = 'export_rgb.php?start_date=' + start_date + '&end_date=' + end_date + '&region=' + region;
            } else {
                alert("Both Date is Required");
            }
            console.log('export');
        }
    });
</script>

</html>