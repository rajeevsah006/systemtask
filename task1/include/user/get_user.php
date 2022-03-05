<?php
header('Content-type: application/json');
$response = array();
session_start();
require_once "../class/SystemTask.php";
$systemTask = new SystemTask();
$user_array = $systemTask->getAllUser();
if (!empty($user_array))
{
	$response['status'] = 'success';
	$response['details'] = $user_array;
}
else
{
	$response['status'] = 'error';
	$response['message'] = 'User not available';
}
echo json_encode($response);
