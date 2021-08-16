<?php
session_start();
function validReferrer($url)
{
    return (isset($_SESSION['referrer']) && $_SESSION["referrer"] == $url);
}
function destroy()
{
    $_SESSION['referrer'] = "";
}
function filterGet($param)
{
    return htmlentities($param, ENT_QUOTES, 'UTF-8');
}

function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}