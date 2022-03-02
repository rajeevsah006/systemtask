<?php
header('Content-type: application/json');
$response = array();
session_start();
require_once "../class/VedaFaculty.php";
$vedaFaculty = new VedaFaculty();
if (isset($_POST["exam_sno"]) && !empty($_POST["exam_sno"]))
{
	$check_marks = $vedaFaculty->isMarksAvailable($_POST['exam_sno']);
	if (!empty($check_marks) && (count($check_marks) == count(explode(',', $_POST['exam_sno']))))
	{
		$count = 0;
		$marks_array = $vedaFaculty->getMarksByExamSno($_POST["exam_sno"]);
		if (!empty($marks_array))
		{
			foreach ($marks_array as $key => $value)
			{
				$details[] = array(
					$marks_array[$key]["marks_sno"],
					++$count,
					'<a class="image-popup-no-margins" href="https://vedaiit.org/application/uploads/' . basename($marks_array[$key]['user_image']) . '"><img src="https://vedaiit.org/application/uploads/' . basename($marks_array[$key]['user_image']) . '" onerror="this.onerror=null; this.parentNode.href=this.src=\'images/logo/user.png\'" width="35" height="35" style="margin: -12px 0px -12px 0px;"></a>',
					$marks_array[$key]["user_id"],
					$marks_array[$key]["first_name"],
					$marks_array[$key]["last_name"],
					$marks_array[$key]["subject_code"] . '_' . $marks_array[$key]["exam_type"],
					$marks_array[$key]["exam_marks"],
					$marks_array[$key]["marks_obtain_r"],
					$marks_array[$key]["marks_obtain_s"],
					$marks_array[$key]["marks_remark"],
					'<a href="' . (count(glob('../../images/answer/exam_' . $marks_array[$key]["exam_sno"] . '/*' . $marks_array[$key]["user_id"] . '*')) > 0 ? 'images/answer/' . glob('../../images/answer/exam_' . $marks_array[$key]["exam_sno"] . '/*' . $marks_array[$key]["user_id"] . '*')[0] : 'javascript:void(0)') . '" target="_blank">Result</a>'
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
		$response['message'] = 'Marks not uploaded for certain exams, Please check';
	}
}
else
{
	$response['status'] = 'error';
	$response['message'] = 'Missing parameters, Try again...';
}
echo json_encode($response);
