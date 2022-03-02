<?php
header('Content-type: application/json');
$response = array();
session_start();
require_once "../class/VedaFaculty.php";
$vedaFaculty = new VedaFaculty();
if (file_exists($_FILES['file_upload']['tmp_name']) || is_uploaded_file($_FILES['file_upload']['tmp_name']))
{
	$file_upload = $_FILES["file_upload"]["tmp_name"];
	if ($_FILES["file_upload"]["size"] > 0)
	{
		$file = fopen($file_upload, "r");
		$column = fgetcsv($file);
		$details = array();
		if (basename($_SERVER['HTTP_REFERER']) == "add_student")
		{
			while (($column = fgetcsv($file)) !== FALSE)
			{
				$details[] = array(
					rand(0, 99999999),
					'<div class="count1"></div>',
					'<a class="image-popup-no-margins" href="images/logo/user.png"><img src="images/logo/user.png" width="35" height="35" style="margin: -12px 0px -12px 0px;"></a>
                <input name="user_image[]" type="hidden" value="" readonly>',
					'<div class="form-group"><input name="user_id[]" type="text" class="form-control" value="' . $column[0] . '" placeholder="Student Id"></div>',
					'<div class="form-group"><input name="first_name[]" type="text" class="form-control" value="' . $column[1] . '" placeholder="First Name"></div>',
					'<div class="form-group"><input name="last_name[]" type="text" class="form-control" value="' . $column[2] . '" placeholder="Last Name"></div>',
					'<div class="form-group"><input name="user_name[]" type="text" class="form-control" value="' . $column[3] . '" placeholder="User Name"></div>
                <input name="domain_id" type="hidden" class="domain_id" value="' . $_POST["domain_id"] . '" readonly>
                <input name="domain_sno" type="hidden" class="domain_sno" value="' . $_POST["domain_sno"] . '" readonly>',
					'<div class="form-group"><input name="user_qualification[]" type="text" class="form-control" value="' . $column[4] . '" placeholder="Qualification"></div>',
					'<div class="form-group"><input name="user_yop[]" type="text" class="form-control" value="' . $column[5] . '" placeholder="YOP"><div>',
					'<div class="form-group"><input name="mobile_no[]" type="text" class="form-control" value="' . $column[6] . '" placeholder="Mobile No"></div>',
					'<div class="form-group"><input name="email_id[]" type="text" class="form-control" value="' . $column[7] . '" placeholder="Email Id"></div>',
					'<div class="form-group"><input name="company_name[]" type="text" class="form-control" value="' . $column[8] . '" placeholder="Company"></div>',
					'<div class="form-group"><input name="training_period[]" type="text" class="form-control" value="' . $column[9] . '" placeholder="Training Period"></div>',
					'<div class="form-group"><input name="bond_amount[]" type="text" class="form-control" value="' . $column[10] . '" placeholder="Bond Amount"></div>',
					'<div class="form-group"><input name="salary_from[]" type="text" class="form-control" value="' . $column[11] . '" placeholder="Salary From"></div>',
					'<div class="form-group"><input name="salary_to[]" type="text" class="form-control" value="' . $column[12] . '" placeholder="Salary To"></div>',
					'<div class="form-group"><input name="user_date[]" type="text" class="form-control datepicker user_date" value="' . $_POST["domain_date"] . '" placeholder="DD-MM-YYYY"></div>'
				);
			}
		}
		elseif (basename($_SERVER['HTTP_REFERER']) == "add_marks")
		{
			$count = 0;
			$exam_array = $vedaFaculty->getStudentByExamSno($_POST["exam_sno"]);
			foreach ($exam_array as $key => $value)
			{
				$details[] = array(
					rand(0, 99999999),
					++$count,
					'<a class="image-popup-no-margins" href="https://vedaiit.org/application/uploads/' . basename($exam_array[$key]['user_image']) . '"><img src="https://vedaiit.org/application/uploads/' . basename($exam_array[$key]['user_image']) . '" onerror="this.onerror=null; this.parentNode.href=this.src=\'images/logo/user.png\'" width="35" height="35" style="margin: -12px 0px -12px 0px;"></a>',
					$exam_array[$key]["user_id"],
					$exam_array[$key]["first_name"],
					$exam_array[$key]["last_name"],
					$exam_array[$key]["subject_code"] . '_' . $exam_array[$key]["exam_type"],
					$exam_array[$key]["exam_marks"],
					'<div class="form-group"><input name="marks_obtain_r[]" type="text" class="form-control" value="' . fgetcsv($file)[1] . '" placeholder="Marks R"></div>
                    <input name="user_sno[]" type="hidden" value="' . $exam_array[$key]["user_sno"] . '" readonly>
                    <input name="exam_sno[]" type="hidden" value="' . $exam_array[$key]["exam_sno"] . '" readonly>',
					'<div class="form-group"><input name="marks_remark[]" type="text" class="form-control" placeholder="Remark"></div>'
				);
			}
		}
		$response['status'] = 'success';
		$response['details'] = $details;
	}
	else
	{
		$response['status'] = 'error';
		$response['message'] = 'You uploaded an empty file';
	}
}
else
{
	$response['status'] = 'error';
	$response['message'] = 'Missing parameters, Try again...';
}
echo json_encode($response);
