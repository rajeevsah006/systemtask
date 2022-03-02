<?php
header('Content-type: application/json');
$response = array();
session_start();
require_once "../class/VedaFaculty.php";
$vedaFaculty = new VedaFaculty();
if (isset($_POST["exam_sno"]) && !empty($_POST["exam_sno"]))
{
	$check_commited = $vedaFaculty->isExamCommited($_POST["exam_sno"]);
	if (!empty($check_commited) && (count($check_commited) == count(explode(',', $_POST['exam_sno']))))
	{
		$count = 0;
		$exam_array = $vedaFaculty->getStudentByExamSno($_POST["exam_sno"]);
		if (!empty($exam_array))
		{
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
					'<div class="form-group"><input name="marks_obtain_r[]" type="text" class="form-control" placeholder="Marks R"></div>
                    <input name="user_sno[]" type="hidden" value="' . $exam_array[$key]["user_sno"] . '" readonly>
                    <input name="exam_sno[]" type="hidden" value="' . $exam_array[$key]["exam_sno"] . '" readonly>',
					'<div class="form-group"><input name="marks_remark[]" type="text" class="form-control" placeholder="Remark"></div>'
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
		$response['message'] = 'Oppss, Marks allready commited for certain exams';
	}
}
else
{
	$response['status'] = 'error';
	$response['message'] = 'Missing parameters, Try again...';
}
echo json_encode($response);
