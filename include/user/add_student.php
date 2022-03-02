<?php
header('Content-type: application/json');
$response = array();
session_start();
require_once "../class/VedaFaculty.php";
$vedaFaculty = new VedaFaculty();
if (isset($_POST['add_button']))
{
	$check_permission = $vedaFaculty->isHrPermissionAvailable($_SESSION['veda_user_sno']);
	if (!empty($check_permission))
	{
		$value_arr = array();
		for ($i = 0; $i < count($_POST['user_id']); $i++)
		{
			$user_id = strtoupper(strip_tags(trim($_POST['user_id'][$i])));
			$first_name = ucwords(strtolower(strip_tags(trim($_POST['first_name'][$i]))));
			$last_name = ucwords(strtolower(strip_tags(trim($_POST['last_name'][$i]))));
			$user_name = strtolower(strip_tags(trim($_POST['user_name'][$i])));
			$hashed_password = hash('sha256', "Veda@123");
			$domain_sno = strip_tags(trim($_POST['domain_sno']));
			$user_type = strip_tags(trim($_SESSION['session_user_type']));
			$user_qualification = strip_tags(trim($_POST['user_qualification'][$i]));
			$user_yop = strip_tags(trim($_POST['user_yop'][$i]));
			$mobile_no = strip_tags(trim($_POST['mobile_no'][$i]));
			$email_id = strtolower(strip_tags(trim($_POST['email_id'][$i])));
			$company_name = strip_tags(trim($_POST['company_name'][$i]));
			$training_period = strip_tags(trim($_POST['training_period'][$i]));
			$bond_amount = strip_tags(trim($_POST['bond_amount'][$i]));
			$salary_from = strip_tags(trim($_POST['salary_from'][$i]));
			$salary_to = strip_tags(trim($_POST['salary_to'][$i]));
			$user_image = strip_tags(trim($_POST['user_image'][$i]));
			$user_visible = 'YES';
			$user_date = strip_tags(trim($_POST['user_date'][$i]));
			$value_arr[] = "('$user_id', '$first_name', '$last_name', '$user_name', '$hashed_password', '$domain_sno', '$user_type', '$user_qualification', '$user_yop', '$mobile_no', '$email_id','$company_name', '$training_period', '$bond_amount', '$salary_from', '$salary_to', '$user_image', '$user_visible', '$user_date')";
		}
		$user_sno = $vedaFaculty->insertUser(implode(',', $value_arr));
		if (!empty($user_sno))
		{
			$response['status'] = 'success';
			$response['message'] = 'Student added sucessfully';
		}
		else
		{
			$response['status'] = 'error';
			$response['message'] = 'Data allready exists';
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
