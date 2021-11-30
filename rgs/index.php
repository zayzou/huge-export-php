<?php
session_start();
include('../db_connect.php');
$type_u = "admin";


$hidden = $type_u == 'admin' || $type_u == 'validateur' || $type_u == 'verificateur' ? '' : "hidden";

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content=""/>
    <meta name="author" content="Soffi Zahir"/>
    <meta http-equiv="Cache-Control" content="public">
    <title>Rapport des Chiffres d'affaires des produits</title>


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
                <h1 class="h2">Rapport des Chiffres d'affaires des produits</h1>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">


                        <div class="col">
                            <input hidden>
                            </input>
                        </div>

                    </div>
                    <div class="row" style="margin-top: 0.2rem;">

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
                        <th>Grossiste</th>
                        <th>Produit</th>
                        <th>janvier</th>
                        <th>février</th>
                        <th>mars</th>
                        <th>avril</th>
                        <th>mai</th>
                        <th>juin</th>
                        <th>juillet</th>
                        <th>août</th>
                        <th>septembre</th>
                        <th>octobre</th>
                        <th>novembre</th>
                        <th>décembre</th>
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

        }

        resetComponents();

        function fetch_data(is_date_search, start_date = '', end_date = '', region = '', produit = '', delegue = '') {
            var dataTable = $('#report_table').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "paging": false,
                "ajax": {
                    url: "fetch_rgs.php",
                    type: "POST",
                    data: {
                        is_date_search: is_date_search,
                    }
                }
            });
        }


        $("#search").click(function () {
            var start_date = $('#start_date').val();
            if (start_date != ""  ) {
                $('#report_table').DataTable().destroy();
                fetch_data('yes', start_date);
                <?php $_SESSION['referrer'] = "rgs.php"; ?>
                $("#export").css({
                    "display": "block"
                });

            } else {
                alert("Both Date is Required");
            }
        });

        $('#btn-export').click(function () {
            var start_date = $('#start_date').val();
            console.log(start_date)
            if (start_date != "") {
                exportData(start_date);
                resetComponents();
            } else {
                alert("Both Date is Required");
            }
        });
        $('#btn-reset').click(function () {
            resetComponents();
        });

        function exportData(start_date) {
            if (start_date ) {
                console.log(start_date + " " + end_date)
                window.location.href = 'export_rcap.php?start_date=' + start_date + '&end_date=' + end_date + '&region=' + region + '&produit=' + produit + '&delegue=' + delegue;
            } else {
                alert("Both Date is Required");
            }
            console.log('export');
        }
    });
</script>

</html>