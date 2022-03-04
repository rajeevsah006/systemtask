<?php
header('Content-type: application/json');
$response = array();
session_start();
require_once "../class/SystemTask.php";
$systemTask = new SystemTask();
$check_permission = $systemTask->isAdminPermissionAvailable($_SESSION['session_user_sno']);
if (!empty($check_permission))
{
	$systemTask->deleteUser($_POST['user_sno']);
	$response['status'] = 'success';
	$response['message'] = 'User deleted sucessfully';
}
else
{
	$response['status'] = 'error';
	$response['message'] = 'You don\'t have permission to delete';
}
echo json_encode($response);
