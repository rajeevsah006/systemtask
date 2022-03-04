<?php
header('Content-type: application/json');
$response = array();
session_start();
require_once "../class/SystemTask.php";
$systemTask = new SystemTask();
if (isset($_POST['add_button']))
{
	$user_sno = $systemTask->insertUser($_POST, $_FILES);
	if (!empty($user_sno))
	{
		$response['status'] = 'success';
		$response['message'] = 'User added sucessfully, Please verify';
	}
	else
	{
		$response['status'] = 'error';
		$response['message'] = 'Something Wrong, Try again...';
	}
}
else
{
	$response['status'] = 'error';
	$response['message'] = 'Missing parameters, Try again...';
}
echo json_encode($response);
