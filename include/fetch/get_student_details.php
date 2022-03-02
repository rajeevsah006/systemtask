<?php
header('Content-type: application/json');
$response = array();
session_start();
require_once "../class/VedaFaculty.php";
$vedaFaculty = new VedaFaculty();
if (isset($_POST["domain_sno"]) && !empty($_POST["domain_sno"]))
{
	$count = 0;
	$user_array = $vedaFaculty->getUserByDomainSno($_POST["domain_sno"]);
	if (!empty($user_array))
	{
		foreach ($user_array as $key => $value)
		{
			$details[] = array(
				$user_array[$key]["user_sno"],
				++$count,
				'<a class="image-popup-no-margins" href="https://vedaiit.org/application/uploads/' . basename($user_array[$key]['user_image']) . '"><img src="https://vedaiit.org/application/uploads/' . basename($user_array[$key]['user_image']) . '" onerror="this.onerror=null; this.parentNode.href=this.src=\'images/logo/user.png\';" width="35" height="35" style="margin: -12px 0px -12px 0px;"></a>',
				$user_array[$key]["user_id"],
				$user_array[$key]["first_name"],
				$user_array[$key]["last_name"],
				$user_array[$key]["user_name"],
				$user_array[$key]["domain_id"],
				$user_array[$key]["user_type"],
				$user_array[$key]["user_qualification"],
				$user_array[$key]["user_yop"],
				$user_array[$key]["mobile_no"],
				$user_array[$key]["email_id"],
				$user_array[$key]["company_name"],
				$user_array[$key]["training_place"],
				$user_array[$key]["work_place"],
				$user_array[$key]["training_period"],
				$user_array[$key]["bond_amount"],
				$user_array[$key]["salary_from"],
				$user_array[$key]["salary_to"],
				$user_array[$key]["user_dop_veda"],
				$user_array[$key]["user_dop_company"],
				$user_array[$key]["user_manager"],
				$user_array[$key]["health_leave"],
				$user_array[$key]["total_late"],
				$user_array[$key]["veda_leave"],
				$user_array[$key]["od_leave"],
				$user_array[$key]["company_leave"],
				$user_array[$key]["extended_days"],
				$user_array[$key]["user_date"],
				$user_array[$key]["user_remark"]
			);
		}
		$response['status'] = 'success';
		$response['details'] = $details;
	}
	else
	{
		$response['status'] = 'error';
		$response['message'] = 'Student not found in this domain';
	}
}
else
{
	$response['status'] = 'error';
	$response['message'] = 'Missing parameters, Try again...';
}
echo json_encode($response);
