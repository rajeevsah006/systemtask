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
	$user_array = $systemTask->getUserByUserSno($_SESSION['session_user_sno']);
	if (!empty($user_array))
	{
		if ($hashed_password == $user_array[0]["user_password"])
		{
			$systemTask->updateUserPassword($_POST, $_SESSION['session_user_sno']);
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
