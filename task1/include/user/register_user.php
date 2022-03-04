<?php
header('Content-type: application/json');
$response = array();
session_start();
require_once "../class/SystemTask.php";
$systemTask = new SystemTask();
if (isset($_POST['register_button']))
{
	$user_sno = $systemTask->insertUser($_POST);
	if (!empty($user_sno))
	{
		$response['status'] = 'success';
		$response['message'] = 'Registered sucessfully, Will verify your details';
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
