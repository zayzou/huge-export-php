<?php
include('db_connect.php');
$query = "SELEC * from table_name WHERE " . 'date BETWEEN "' . $_POST["start_date"] . '" AND "' . $_POST["end_date"] . '"';
$statement = $pdo->prepare($query);
$statement->execute();
$total_rows = $statement->rowCount();


if (isset($_POST["region"])) {
    $query .= ' AND region LIKE "%' . $_POST["region"] . '%"';
}
$statement = $pdo->prepare($query);
$statement->execute();
$total_rows = $statement->rowCount();
// print_r($query);
if (isset($_POST["search"]["value"])) {
    $query .= ' AND CONCAT_WS("", firstname,lastname,region) LIKE "%' . $_POST["search"]["value"] . '%"';
}
if (isset($_POST["order"])) {

    $query .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
}

if ($_POST["length"] != -1) {
    $query .= ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $pdo->prepare($query);
$statement->execute();
$data = array();
$filtered_rows = $statement->rowCount();

$result = $statement->fetchAll();
$i = 1;
foreach ($result as $row) {
    $sub_array = array();
    $sub_array[] = $i++;
    foreach ($row as   $value) {
        $sub_array[] = $value;
    }
    $data[] = $sub_array;
}
$output = array(
    "draw" => intval($_POST["draw"]),
    "recordsTotal" => $filtered_rows,
    "recordsFiltered" => $total_rows,
    "data" => $data
);
echo json_encode($output);
