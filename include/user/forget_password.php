<?php
header('Content-type: application/json');
$response = array();
session_start();
require_once "../class/VedaFaculty.php";
$vedaFaculty = new VedaFaculty();
if (isset($_POST['forget_button']))
{
	$user_name = strtolower(strip_tags(trim($_POST['user_name'])));
	$mobile_no = strip_tags(trim($_POST['mobile_no']));
	$user_array = $vedaFaculty->validateUserName($user_name);
	if (!empty($user_array))
	{
		if ($user_array[0]["mobile_no"] == $mobile_no)
		{
			$request_array = $vedaFaculty->isPasswordRequestAvailable($user_array[0]["user_sno"]);
			if (empty($request_array))
			{
				$request_sno = $vedaFaculty->sendForgetRequest($user_array[0]["user_sno"]);
				if (!empty($request_sno))
				{
					$response['status'] = 'success';
					$response['message'] = 'We sent an request, Please contact adminstration department for your new password.';
				}
				else
				{
					$response['status'] = 'error';
					$response['message'] = 'Could not able to send password reset request, Try again...';
				}
			}
			else
			{
				$response['status'] = 'error';
				$response['message'] = 'We all reday recieved an request, Please contact adminstration department for your new password.';
			}
		}
		else
		{
			$response['status'] = 'error';
			$response['message'] = 'Wrong mobile number, Try again...';
		}
	}
	else
	{
		$response['status'] = 'error';
		$response['message'] = 'User not exists , Please Try another one';
	}
}
else
{
	$response['status'] = 'error';
	$response['message'] = 'Missing parameters, Try again...';
}
echo json_encode($response);
