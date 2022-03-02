<?php
header('Content-type: application/json');
$response = array();
session_start();
require_once "../class/VedaFaculty.php";
$vedaFaculty = new VedaFaculty();
$check_permission = $vedaFaculty->isHrPermissionAvailable($_SESSION['veda_user_sno']);
if (!empty($check_permission))
{
	if (empty($_FILES['file_upload']['name']))
	{
		$_POST = array(
			"user_sno" => isset($_POST['updatedRow']) ? $_POST['updatedRow'][0] : $_POST['user_sno'],
			"first_name" => isset($_POST['updatedRow']) ? $_POST['updatedRow'][4] : "Unchanged",
			"last_name" => isset($_POST['updatedRow']) ? $_POST['updatedRow'][5] : "Unchanged",
			"user_name" => isset($_POST['updatedRow']) ? $_POST['updatedRow'][6] : "Unchanged",
			"user_password" => isset($_POST['user_password']) ? $_POST['user_password'] : "Unchanged",
			"user_type" => isset($_POST['updatedRow']) ? $_POST['updatedRow'][8] : "Unchanged",
			"user_qualification" => isset($_POST['updatedRow']) ? $_POST['updatedRow'][9] : "Unchanged",
			"user_yop" => isset($_POST['updatedRow']) ? $_POST['updatedRow'][10] : "Unchanged",
			"mobile_no" => isset($_POST['updatedRow']) ? $_POST['updatedRow'][11] : "Unchanged",
			"email_id" => isset($_POST['updatedRow']) ? $_POST['updatedRow'][12] : "Unchanged",
			"company_name" => isset($_POST['updatedRow']) ? $_POST['updatedRow'][13] : "Unchanged",
			"training_place" => isset($_POST['updatedRow']) ? $_POST['updatedRow'][14] : (isset($_POST['training_place']) ? (preg_match('/\S/', $_POST['training_place']) ? $_POST['training_place'] : "Unchanged") : "Unchanged"),
			"work_place" => isset($_POST['updatedRow']) ? $_POST['updatedRow'][15] : (isset($_POST['work_place']) ? (preg_match('/\S/', $_POST['work_place']) ? $_POST['work_place'] : "Unchanged") : "Unchanged"),
			"training_period" => isset($_POST['updatedRow']) ? $_POST['updatedRow'][16] : "Unchanged",
			"bond_amount" => isset($_POST['updatedRow']) ? $_POST['updatedRow'][17] : "Unchanged",
			"salary_from" => isset($_POST['updatedRow']) ? $_POST['updatedRow'][18] : "Unchanged",
			"salary_to" => isset($_POST['updatedRow']) ? $_POST['updatedRow'][19] : "Unchanged",
			"user_dop_veda" => isset($_POST['updatedRow']) ? $_POST['updatedRow'][20] : (isset($_POST['user_dop_veda']) ? (preg_match('/\S/', $_POST['user_dop_veda']) ? $_POST['user_dop_veda'] : "Unchanged") : "Unchanged"),
			"user_dop_company" => isset($_POST['updatedRow']) ? $_POST['updatedRow'][21] : (isset($_POST['user_dop_company']) ? (preg_match('/\S/', $_POST['user_dop_company']) ? $_POST['user_dop_company'] : "Unchanged") : "Unchanged"),
			"user_manager" => isset($_POST['updatedRow']) ? $_POST['updatedRow'][22] : "Unchanged",
			"health_leave" => isset($_POST['updatedRow']) ? $_POST['updatedRow'][23] : "Unchanged",
			"total_late" => isset($_POST['updatedRow']) ? $_POST['updatedRow'][24] : (isset($_POST['total_late']) ? (preg_match('/\S/', $_POST['total_late']) ? $_POST['total_late'] : "Unchanged") : "Unchanged"),
			"veda_leave" => isset($_POST['updatedRow']) ? $_POST['updatedRow'][25] : (isset($_POST['veda_leave']) ? (preg_match('/\S/', $_POST['veda_leave']) ? $_POST['veda_leave'] : "Unchanged") : "Unchanged"),
			"od_leave" => isset($_POST['updatedRow']) ? $_POST['updatedRow'][26] : (isset($_POST['od_leave']) ? (preg_match('/\S/', $_POST['od_leave']) ? $_POST['od_leave'] : "Unchanged") : "Unchanged"),
			"company_leave" => isset($_POST['updatedRow']) ? $_POST['updatedRow'][27] : (isset($_POST['company_leave']) ? (preg_match('/\S/', $_POST['company_leave']) ? $_POST['company_leave'] : "Unchanged") : "Unchanged"),
			"extended_days" => isset($_POST['updatedRow']) ? $_POST['updatedRow'][28] : "Unchanged",
			"user_date" => isset($_POST['updatedRow']) ? $_POST['updatedRow'][29] : "Unchanged",
			"user_remark" => isset($_POST['updatedRow']) ? $_POST['updatedRow'][30] : (isset($_POST['user_remark']) ? (preg_match('/\S/', $_POST['user_remark']) ? $_POST['user_remark'] : "Unchanged") : "Unchanged"),
		);
		$vedaFaculty->updateUser($_POST);
		$response['status'] = 'success';
		$response['message'] = 'Details updated sucessfully';
	}
	else
	{
		$file_upload = $_FILES["file_upload"]["tmp_name"];
		if ($_FILES["file_upload"]["size"] > 0)
		{
			$file = fopen($file_upload, "r");
			$column = fgetcsv($file);
			$value_arr = array();
			foreach (explode(',', $_POST['user_sno']) as $user_sno)
			{
				$column = fgetcsv($file);
				$user_sno = strip_tags(trim($user_sno));
				$health_leave = strip_tags(trim($column[1]));
				$total_late = strip_tags(trim($column[2]));
				$veda_leave = strip_tags(trim($column[3]));
				$od_leave = strip_tags(trim($column[4]));
				$company_leave = strip_tags(trim($column[5]));
				$value_arr[] = "($user_sno, $health_leave, $total_late, $veda_leave, $od_leave, $company_leave)";
			}
			$vedaFaculty->updateLeave(implode(',', $value_arr));
			$response['status'] = 'success';
			$response['details'] = $value_arr;
		}
		else
		{
			$response['status'] = 'error';
			$response['message'] = 'You uploaded an empty file';
		}
	}
}
else
{
	$response['status'] = 'error';
	$response['message'] = 'You don\'t have permission to update';
}
echo json_encode($response);
