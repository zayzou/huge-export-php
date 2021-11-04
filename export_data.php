<?php
function exportToExcel($fileName = '', $headArr = [], $data = [])
{

    ini_set('memory_limit', '1024M'); // setup program run out of memory
    ini_set('max_execution_time', 10); // set the execution time of the program, uncapped 0
    ob_end_clean(); // Clear memory
    ob_start();
    header("Content-Type: text/csv");
    header("Content-Disposition:filename=" . $fileName . '.csv');
    $fp = fopen('php://output', 'w');
    fwrite($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));
    fputcsv($fp, $headArr, ";");
    $index = 0;
    foreach ($data as $row) {
        $sub_data = array();
        foreach ($row as  $value) {
            $sub_data[] = $value;
        }
        if ($index == 1000) { // each write memory data clear 1000
            $index = 0;
            ob_flush(); // Clear memory
            flush();
        }
        $index++;
        fputcsv($fp, $sub_data, ";");
    }
    ob_flush();
    flush();
    ob_end_clean();
    exit();
}
