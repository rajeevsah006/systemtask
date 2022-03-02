<?php
require_once "../class/VedaFaculty.php";
$vedaFaculty = new VedaFaculty();
$check_faculty = $vedaFaculty->isUserNameAvailable($_POST['user_name']);
if (!empty($check_faculty))
{
    echo 'false';
}
else
{
    echo 'true';
}
?>