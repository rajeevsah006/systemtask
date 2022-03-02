<?php
header('Content-type: application/json');
$response = array();
session_start();
require_once "../class/VedaFaculty.php";
$vedaFaculty = new VedaFaculty();
if (isset($_POST["domain_id"]) && !empty($_POST["domain_id"]))
{
	$url = "https://vedaiit.org/application/veda_examination/student/batch_students_list_from_veda.php";
	$postData = array(
		'key' => $vedaFaculty->safe_b64encode("V3d@$#4279"),
		'batch' => $_POST["domain_id"]
	);
	$ch = curl_init();
	curl_setopt_array($ch, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $postData
		//,CURLOPT_FOLLOWLOCATION => true
	));
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	$server_arr = json_decode(curl_exec($ch), true);
	$err = curl_error($ch);
	curl_close($ch);
	if (!empty($server_arr))
	{
		foreach ($server_arr as $key => $value)
		{
			$details[] = array(
				rand(0, 99999999),
				'<div class="count1"></div>',
				'<a class="image-popup-no-margins" href="https://vedaiit.org/application/uploads/' . basename($server_arr[$key]['photo']) . '"><img src="https://vedaiit.org/application/uploads/' . basename($server_arr[$key]['photo']) . '" onerror="this.onerror=null; this.parentNode.href=this.src=\'images/logo/user.png\'" width="35" height="35" style="margin: -12px 0px -12px 0px;"></a>
                <input name="user_image[]" type="hidden" value="' . strip_tags(trim($server_arr[$key]['photo'])) . '" readonly>',
				'<div class="form-group"><input name="user_id[]" type="text" class="form-control" value="' . strtoupper(strip_tags(trim($server_arr[$key]['roll_num']))) . '" placeholder="Student Id"></div>',
				'<div class="form-group"><input name="first_name[]" type="text" class="form-control" value="' . ucwords(strtolower(strip_tags(trim($server_arr[$key]['first_name'])))) . '" placeholder="First Name"></div>',
				'<div class="form-group"><input name="last_name[]" type="text" class="form-control" value="' . ucwords(strtolower(strip_tags(trim($server_arr[$key]['last_name'])))) . '" placeholder="Last Name"></div>',
				'<div class="form-group"><input name="user_name[]" type="text" class="form-control" value="' . str_replace(' ', '', strtolower(strip_tags(trim($server_arr[$key]['first_name'][0] . $server_arr[$key]['last_name'])))) . '" placeholder="User Name"></div>
				<input name="domain_id" type="hidden" class="domain_id" value="' . $_POST["domain_id"] . '" readonly>
                <input name="domain_sno" type="hidden" class="domain_sno" value="' . $_POST["domain_sno"] . '" readonly>',
				'<div class="form-group"><input name="user_qualification[]" type="text" class="form-control" value="' . strip_tags(trim($server_arr[$key]['qualification'])) . '" placeholder="Qualification"></div>',
				'<div class="form-group"><input name="user_yop[]" type="text" class="form-control" value="' . strip_tags(trim($server_arr[$key]['year_of_passing'])) . '" placeholder="YOP"><div>',
				'<div class="form-group"><input name="mobile_no[]" type="text" class="form-control" value="' . strip_tags(trim($server_arr[$key]['mobile_number'])) . '" placeholder="Mobile No"></div>',
				'<div class="form-group"><input name="email_id[]" type="text" class="form-control" value="' . strtolower(strip_tags(trim($server_arr[$key]['email_id']))) . '" placeholder="Email Id"></div>',
				'<div class="form-group"><input name="company_name[]" type="text" class="form-control" value="' . strip_tags(trim($server_arr[$key]['company_name'])) . '" placeholder="Company"></div>',
				'<div class="form-group"><input name="training_period[]" type="text" class="form-control" value="' . strip_tags(trim($server_arr[$key]['training_period'])) . '" placeholder="Training Period"></div>',
				'<div class="form-group"><input name="bond_amount[]" type="text" class="form-control" value="' . strip_tags(trim($server_arr[$key]['aggregate_amt'])) . '" placeholder="Bond Amount"></div>',
				'<div class="form-group"><input name="salary_from[]" type="text" class="form-control" value="' . strip_tags(trim($server_arr[$key]['loi_from_salary'])) . '" placeholder="Salary From"></div>',
				'<div class="form-group"><input name="salary_to[]" type="text" class="form-control" value="' . strip_tags(trim($server_arr[$key]['loi_to_salary'])) . '" placeholder="Salary To"></div>',
				'<div class="form-group"><input name="user_date[]" type="text" class="form-control datepicker user_date" value="' . $_POST["domain_date"] . '" placeholder="DD-MM-YYYY"></div>'
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
