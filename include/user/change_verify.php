<?php
header('Content-type: application/json');
$response = array();
session_start();
require_once "../class/SystemTask.php";
$systemTask = new SystemTask();
$check_permission = $systemTask->isAdminPermissionAvailable($_SESSION['session_user_sno']);
if (!empty($check_permission))
{
	$systemTask->updateUserVerified($_POST['user_verified'], $_POST['user_sno']);
	$response['status'] = 'success';
	$response['message'] = 'Details updated sucessfully';
}
else
{
	$response['status'] = 'error';
	$response['message'] = 'You don\'t have permission to update';
}
echo json_encode($response);
