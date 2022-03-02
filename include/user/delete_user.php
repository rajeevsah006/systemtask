<?php
header('Content-type: application/json');
$response = array();
session_start();
require_once "../class/VedaFaculty.php";
$vedaFaculty = new VedaFaculty();
$check_permission = $vedaFaculty->isAdminPermissionAvailable($_SESSION['veda_user_sno']);
if (!empty($check_permission))
{
    if (!in_array($_SESSION['veda_user_sno'], explode(',', $_POST['user_sno'])))
    {
        $vedaFaculty->deleteUser($_POST['user_sno']);
        $response['status'] = 'success';
        $response['message'] = 'User deleted sucessfully';
    }
    else
    {
        $response['status'] = 'error';
        $response['message'] = 'You can\'t delete your self';
    }
}
else
{
    $response['status'] = 'error';
    $response['message'] = 'You don\'t have permission to delete';
}
echo json_encode($response);
