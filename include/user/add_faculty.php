<?php
header('Content-type: application/json');
$response = array();
session_start();
require_once "../class/VedaFaculty.php";
$vedaFaculty = new VedaFaculty();
if (isset($_POST['add_button']))
{
	$check_permission = $vedaFaculty->isAdminPermissionAvailable($_SESSION['veda_user_sno']);
	if (!empty($check_permission))
	{
		$value_arr = array();
		$user_id = strtoupper(strip_tags(trim($_POST['user_id'])));
		$first_name = ucwords(strtolower(strip_tags(trim($_POST['first_name']))));
		$last_name = ucwords(strtolower(strip_tags(trim($_POST['last_name']))));
		$user_name = strtolower(strip_tags(trim($_POST['user_name'])));
		$hashed_password = hash('sha256', "Veda@123");
		$domain_sno = strip_tags(trim($_POST['domain_sno']));
		$user_type = strip_tags(trim($_POST['user_type']));
		$mobile_no = strip_tags(trim($_POST['mobile_no']));
		$email_id = strtolower(strip_tags(trim($_POST['email_id'])));
		$user_visible = 'YES';
		$user_date = date("d-m-Y");
		$value_arr[] = "('$user_id', '$first_name', '$last_name', '$user_name', '$hashed_password', '$domain_sno', '$user_type', '', '', '$mobile_no', '$email_id','', '', '', '', '', '', '$user_visible', '$user_date')";
		$user_sno = $vedaFaculty->insertUser(implode(',', $value_arr));
		if (!empty($user_sno))
		{
			$response['status'] = 'success';
			$response['message'] = 'Faculty added sucessfully';
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
		$response['message'] = 'You don\'t have permission to add';
	}
}
else
{
	$response['status'] = 'error';
	$response['message'] = 'Missing parameters, Try again...';
}
echo json_encode($response);
