<?php
header('Content-type: application/json');
$response = array();
session_start();
require_once "../class/SystemTask.php";
$systemTask = new SystemTask();
if (isset($_POST['update_button']))
{
	$systemTask->updateUser($_POST, $_FILES);
	$response['status'] = 'success';
	$response['message'] = 'User update sucessfully...';
}
else
{
	$response['status'] = 'error';
	$response['message'] = 'Missing parameters, Try again...';
}
echo json_encode($response);
