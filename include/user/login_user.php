<?php
header('Content-type: application/json');
$response = array();
session_start();
require_once "../class/SystemTask.php";
$systemTask = new SystemTask();
if (isset($_POST['login_button']))
{
	$user_name = strtolower(strip_tags(trim($_POST['user_name'])));
	$user_password = strip_tags(trim($_POST['user_password']));
	$user_type = strip_tags(trim($_POST['user_type']));
	$user_array = $vedaFaculty->validateUserName($user_name);
	if (!empty($user_array))
	{
		if ($user_array[0]["user_password"] == hash('sha256', $user_password))
		{
			if ($user_array[0]["user_type"] == $user_type || !in_array($user_array[0]["user_type"], array('Diploma', 'MS')))
			{
				$_SESSION['veda_user_sno'] = $user_array[0]["user_sno"];
				$_SESSION['veda_user_type'] = $user_array[0]["user_type"];
				$_SESSION['session_user_type'] = $user_type;
				$response['status'] = 'success';
				$response['message'] = 'Login sucessfully...';
			}
			else
			{
				$response['status'] = 'error';
				$response['message'] = 'Wrong user type, Try again...';
			}
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
