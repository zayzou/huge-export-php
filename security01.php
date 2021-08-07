<?php
// Start the session
session_start();
function validReferrer($url)
{
    return (isset($_SESSION['referrer']) && $_SESSION["referrer"] == $url);
}
function destroy()
{
    $_SESSION['referrer'] = "";
}
