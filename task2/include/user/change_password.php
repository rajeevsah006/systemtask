<?php
header('Content-type: application/json');
$response = array();
session_start();
require_once "../class/SystemTask.php";
$systemTask = new SystemTask();
if (isset($_POST['change_button']))
{
	$old_password = strip_tags(trim($_POST['old_password']));
	$hashed_password = hash('sha256', $old_password);
	$employee_array = $systemTask->getEmployeeByemployeeSno($_SESSION['session_employee_sno']);
	if (!empty($employee_array))
	{
		if ($hashed_password == $employee_array[0]["employee_password"])
		{
			$systemTask->updateEmployeePassword($_POST, $_SESSION['session_employee_sno']);
			$response['status'] = 'success';
			$response['message'] = 'Password Change sucessfully, Login again to verify';
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
		$response['message'] = 'Could not Change, Try again...';
	}
}
else
{
	$response['status'] = 'error';
	$response['message'] = 'Missing parameters, Try again...';
}
echo json_encode($response);
