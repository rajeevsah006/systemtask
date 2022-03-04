<?php
header('Content-type: application/json');
$response = array();
session_start();
require_once "../class/SystemTask.php";
$systemTask = new SystemTask();
if (isset($_POST['login_button']))
{
	$employee_email = strtolower(strip_tags(trim($_POST['employee_email'])));
	$employee_password = strip_tags(trim($_POST['employee_password']));
	$employee_array = $systemTask->validateUserName($employee_email);
	if (!empty($employee_array))
	{
		if ($employee_array[0]["employee_password"] == hash('sha256', $employee_password))
		{
			$_SESSION['session_employee_sno'] = $employee_array[0]["employee_sno"];
			$_SESSION['session_employee_role'] = $employee_array[0]["employee_role"];
			$response['status'] = 'success';
			$response['message'] = 'Login sucessfully...';
		}
		else
		{
			$response['status'] = 'error';
			$response['message'] = 'Wrong password, Try again...';
		}
	}
	else
	{
		$response['status'] = 'error';
		$response['message'] = 'Incorrect Credentials, Try again...';
	}
}
else
{
	$response['status'] = 'error';
	$response['message'] = 'Missing parameters, Try again...';
}
echo json_encode($response);
