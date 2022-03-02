<?php
header('Content-type: application/json');
$response = array();
session_start();
require_once "../class/VedaFaculty.php";
$vedaFaculty = new VedaFaculty();
if (isset($_POST['show_button']))
{
	if ($_SESSION['session_user_type'] == 'Diploma')
	{
		$marks_array = $_SESSION['veda_user_type'] != 'Diploma' ? $vedaFaculty->getDiplomaMarksByDomainSno(implode(',', $_POST['domain_sno'])) : $vedaFaculty->getDiplomaMarksByUserSno($_POST['user_sno']);
		if (!empty($marks_array))
		{
			$email_id = "rajeev.sah006@gmail.com;rajeevkumar.sah@vedaiit.com";
			$cc = "rajeev.sah006@gmail.com;rajeevkumar.sah@vedaiit.com";
			$subject = "Result of " . $marks_array[0]['domain_id'];
			$body = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.%0D%0A %0D%0Aconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.%0D%0A %0D%0ALorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.%0D%0A %0D%0ADuis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
			$response['details'] = '
			<div class="row">
			<div class="col-md-12">
			<div class="card">
			<div class="card-body">
			<div class="row">
			<div class="col-md-6">
			<div class="mb-4" style="display:inline-block;">
			<select id="hide_column" class="form-control form-control-sm" multiple="multiple">
			<option value=".head-tr">Table Head</option>
			<option value=".supp-td">Supp Marks</option>
			<option value=".highest-td">Highest Marks</option>
			<option value=".percentage-td">Percentage</option>
			</select>
			</div>';
			if ($_SESSION['veda_user_type'] != 'Diploma')
			{
				$response['details'] .= '
				<div style="display:inline-block;margin-left:10px;">
				<button class="btn btn-success btn-sm shadow-none" id="copy-btn" data-clipboard-target="#marks-table"><i class="fas fa-copy"></i>&nbsp;Copy</button>
				</div>
				<div style="display:inline-block;margin-left:10px;">
				<button class="btn btn-danger btn-sm shadow-none" id="export-btn"><i class="fas fa-download"></i>&nbsp;Export</button>
				</div>
				<div style="display:inline-block;margin-left:10px;">
				<a href="mailto:' . $email_id . '?subject=' . $subject . '&body=' . $body . '&cc=' . $cc . '" class="btn btn-info btn-sm shadow-none" id="mail-btn"><i class="fas fa-share"></i>&nbsp;Share</a>
				</div>';
			}
			$response['details'] .= '
			<div style="display:inline-block;margin-left:10px;">
			<a onclick="$(\'#result\').toggleFullScreen()" class="btn shadow-none text-secondary" id="expand-btn"><i class="fas fa-expand-arrows-alt"></i></a>
			</div>
			</div>';
			if ($_SESSION['veda_user_type'] != 'Diploma')
			{
				$response['details'] .= '
				<div class="col-md-6">
				<label style="float: right;">Search:<input type="search" class="form-control form-control-sm filter" placeholder="Search records" data-tablefilter="#marks-table"></label>
				</div>';
			}
			$response['details'] .= '
			</div>
			<div class="table-responsive">
			<table class="table table-striped table-bordered display nowrap" id="marks-table" width="100%">';
			$exam_date = '
			<tr class="head-tr">
			<th colspan="5">Exam Date</th>';
			$result_date = '
			<tr class="head-tr">
			<th colspan="5">Result Date</th>';
			$subject_marks = '
			<tr class="head-tr">
			<th colspan="5">Subject Marks</th>';
			$table_header = '
			<tr>
			<th data-sort="int" data-sort-default="desc">S.No.</th>
			<th>Image</th>
			<th data-sort="string" data-sort-default="desc">Student Id</th>
			<th data-sort="string" data-sort-default="desc">First Name</th>
			<th data-sort="string">Last Name</th>';
			$table_body = '<tbody>';
			$current_student = "";
			$count = 0;
			$flag = false;
			foreach ($marks_array as $key => $value)
			{
				if ($marks_array[$key]["user_sno"] == $marks_array[0]["user_sno"])
				{
					$exam_date .= '
					<th class="supp-td">' . $marks_array[$key]["exam_date_r"] . '</th>
					<th class="supp-td">' . $marks_array[$key]["exam_date_s"] . '</th>
					<th class="colspan-td highest-td" colspan="3"></th>';
					$result_date .= '
					<th class="supp-td">' . $marks_array[$key]["result_date_r"] . '</th>
					<th class="supp-td">' . $marks_array[$key]["result_date_s"] . '</th>
					<th class="colspan-td highest-td" colspan="3"></th>';
					$subject_marks .= '
					<th class="supp-td">' . $marks_array[$key]["exam_marks"] . '</th>
					<th class="supp-td">' . $marks_array[$key]["exam_marks"] . '</th>
					<th class="colspan-td highest-td" colspan="3"></th>';
					$table_header .= '
					<th class="supp-td" title="' . $marks_array[$key]["subject_name"] . '">' . $marks_array[$key]["subject_code"] . '_' . $marks_array[$key]["exam_type"] . '_R</th>
					<th class="supp-td" title="' . $marks_array[$key]["subject_name"] . '">' . $marks_array[$key]["subject_code"] . '_' . $marks_array[$key]["exam_type"] . '_S</th>
					<th class="highest-td" data-sort="float" title="' . $marks_array[$key]["subject_name"] . '">' . $marks_array[$key]["subject_code"] . '_' . $marks_array[$key]["exam_type"] . '_H</th>
					<th class="supp-td">Pass Date</th>
					<th class="supp-td">Answer</th>';
				}
				if ($marks_array[$key]["user_sno"] != $current_student)
				{
					if ($flag)
					{
						$late_leave =  round($marks_array[$key - 1]["total_late"] / 6, 1);
						$total_veda_leave = round(((($late_leave + $marks_array[$key - 1]["veda_leave"] - $marks_array[$key - 1]["od_leave"] - $marks_array[$key - 1]["casual_leave"]) * 2) - min($marks_array[$key - 1]["health_leave"], 6)) < 0 ? 0 : ((($late_leave + $marks_array[$key - 1]["veda_leave"] - $marks_array[$key - 1]["od_leave"] - $marks_array[$key - 1]["casual_leave"]) * 2) - min($marks_array[$key - 1]["health_leave"], 6)));
						$veda_working_days = empty($marks_array[$key - 1]["user_dop_veda"]) ? 'NA' : $vedaFaculty->getWorkingDays($marks_array[$key - 1]["dop_veda"], $marks_array[$key - 1]["user_dop_veda"]);
						$company_doc = empty($marks_array[$key - 1]["user_dop_veda"]) ? 'NA' : (stripos($marks_array[$key - 1]["company_name"], "VEDA") === false ? $vedaFaculty->getNextWorkingDate1($marks_array[$key - 1]["dop_company"], $total_veda_leave + $veda_working_days + 1) : $vedaFaculty->getNextWorkingDate2($marks_array[$key - 1]["dop_company"], $total_veda_leave + $veda_working_days + 1));
						$credit_leave = round(($late_leave + $marks_array[$key - 1]["veda_leave"] - $marks_array[$key - 1]["od_leave"] - $marks_array[$key - 1]["casual_leave"]) >= 0 ? 0 : ($late_leave + $marks_array[$key - 1]["veda_leave"] - $marks_array[$key - 1]["od_leave"] - $marks_array[$key - 1]["casual_leave"]));
						$total_company_leave = ($credit_leave + $marks_array[$key - 1]["extended_days"] + $marks_array[$key - 1]["company_leave"]) <= 0 ? 0 : ($credit_leave + $marks_array[$key - 1]["extended_days"] + $marks_array[$key - 1]["company_leave"]);
						$company_working_days = empty($marks_array[$key - 1]["user_dop_company"]) ? 'NA' : $vedaFaculty->getWorkingDays($marks_array[$key - 1]["dop_company"], $marks_array[$key - 1]["user_dop_company"]);
						$company_doj = empty($marks_array[$key - 1]["user_dop_company"]) ? 'NA' : (stripos($marks_array[$key - 1]["company_name"], "VEDA") === false ? $vedaFaculty->getNextWorkingDate1($company_doc, $total_company_leave + $company_working_days) : $vedaFaculty->getNextWorkingDate2($company_doc, $total_company_leave + $company_working_days));
						$table_body .= '
						<td class="highest-td" title="' . $marks_array[$key - 1]["user_id"] . ' ' . $marks_array[$key - 1]["first_name"] . ' ' . $marks_array[$key - 1]["last_name"] . '">' . number_format($marks_array[$key - 1]["student_total"], 2) . '</td>
						<td class="percentage-td" title="' . $marks_array[$key - 1]["user_id"] . ' ' . $marks_array[$key - 1]["first_name"] . ' ' . $marks_array[$key - 1]["last_name"] . '" ' . ($marks_array[$key - 1]["student_percentage"] < 50 ? 'style="color:red;"' : '') . '>' . $marks_array[$key - 1]["student_percentage"] . '</td>
						<td class="percentage-td">' . ($marks_array[$key - 1]["student_percentage"] < 50 ? 'NI' : ($marks_array[$key - 1]["student_percentage"] < 65 ? 'M' : ($marks_array[$key - 1]["student_percentage"] < 80 ? 'M+' : ($marks_array[$key - 1]["student_percentage"] < 90 ? 'E' : 'O')))) . '</td>
						<td>' . (empty($marks_array[$key - 1]["user_dop_veda"]) ? 'NA' : $marks_array[$key - 1]["user_dop_veda"]) . '</td>
						<td>' . (empty($marks_array[$key - 1]["user_dop_veda"]) ? 'NA' : ($marks_array[$key - 1]["student_percentage"] < 50 ? 'Fail' : (strtotime($marks_array[$key - 1]["user_dop_veda"]) > strtotime($marks_array[$key - 1]["dop_veda"]) ? 'Supp' : 'Pass'))) . '</td>
						<td>' . (empty($marks_array[$key - 1]["user_dop_company"]) ? 'NA' : $marks_array[$key - 1]["user_dop_company"]) . '</td>
						<td>' . (empty($marks_array[$key - 1]["user_dop_company"]) ? 'NA' : (strtotime($marks_array[$key - 1]["user_dop_company"]) > strtotime($marks_array[$key - 1]["dop_company"]) ? 'Supp' : 'Pass')) . '</td>
						<td>' . $marks_array[$key - 1]["user_qualification"] . '</td>
						<td>' . $marks_array[$key - 1]["user_yop"] . '</td>
						<td>' . $marks_array[$key - 1]["company_name"] . '</td>
						<td>' . $marks_array[$key - 1]["training_place"] . '</td>
						<td>' . $marks_array[$key - 1]["work_place"] . '</td>
						<td>' . $marks_array[$key - 1]["training_period"] . '</td>
						<td>' . $marks_array[$key - 1]["bond_amount"] . '</td>
						<td>' . $marks_array[$key - 1]["salary_from"] . '</td>
						<td>' . $marks_array[$key - 1]["salary_to"] . '</td>
						<td>' . $marks_array[$key - 1]["health_leave"] . '</td>
						<td>' . $marks_array[$key - 1]["total_late"] . '</td>
						<td>' . $late_leave . '</td>
						<td>' . $marks_array[$key - 1]["veda_leave"] . '</td>
						<td>' . $marks_array[$key - 1]["od_leave"] . '</td>
						<td>' . $marks_array[$key - 1]["casual_leave"] . '</td>
						<td>' . $total_veda_leave . '</td>
						<td>' . $veda_working_days . '</td>
						<td>' . $company_doc . '</td>
						<td>' . $credit_leave . '</td>
						<td>' . $marks_array[$key - 1]["extended_days"] . '</td>
						<td>' . $marks_array[$key - 1]["company_leave"] . '</td>
						<td>' . $total_company_leave . '</td>
						<td>' . $company_working_days . '</td>
						<td title="' . $marks_array[$key - 1]["user_id"] . ' ' . $marks_array[$key - 1]["first_name"] . ' ' . $marks_array[$key - 1]["last_name"] . '">' . $company_doj . '</td>
						<td title="' . $marks_array[$key - 1]["user_id"] . ' ' . $marks_array[$key - 1]["first_name"] . ' ' . $marks_array[$key - 1]["last_name"] . '">' . (empty($marks_array[$key - 1]["user_dop_company"]) || empty($marks_array[$key - 1]["salary_from"]) || empty($marks_array[$key - 1]["salary_to"]) ? 'NA' : (strtotime($marks_array[$key - 1]["user_dop_company"]) > strtotime($marks_array[$key - 1]["dop_company"]) ? number_format($marks_array[$key - 1]["salary_from"], 2) : (stripos($marks_array[$key - 1]["domain_id"], "AD") === false ? ($marks_array[$key - 1]["student_percentage"] < 65 ? number_format($marks_array[$key - 1]["salary_from"], 2) : ($marks_array[$key - 1]["student_percentage"] < 80 ? number_format($marks_array[$key - 1]["salary_from"] + ((($marks_array[$key - 1]["salary_to"] - $marks_array[$key - 1]["salary_from"]) / 3) * 1), 2) : ($marks_array[$key - 1]["student_percentage"] < 90 ? number_format($marks_array[$key - 1]["salary_from"] + ((($marks_array[$key - 1]["salary_to"] - $marks_array[$key - 1]["salary_from"]) / 3) * 2), 2) : number_format($marks_array[$key - 1]["salary_from"] + ((($marks_array[$key - 1]["salary_to"] - $marks_array[$key - 1]["salary_from"]) / 3) * 3), 2)))) : number_format((($marks_array[$key - 1]["student_percentage"] - 50) / 100) + $marks_array[$key - 1]["salary_from"], 2)))) . '</td>
						<td>' . $marks_array[$key - 1]["user_manager"] . '</td>
						<td>' . $marks_array[$key - 1]["user_remark"] . '</td>
						</tr><tr>
						<td>' . ++$count . '</td>
						<td><a class="image-popup-no-margins" href="https://vedaiit.org/application/uploads/' . basename($marks_array[$key]['user_image']) . '"><img src="https://vedaiit.org/application/uploads/' . basename($marks_array[$key]['user_image']) . '" onerror="this.onerror=null; this.parentNode.href=this.src=\'images/logo/user.png\'" width="35" height="35" style="margin: -12px 0px -12px 0px;"></a></td>
						<td>' . $marks_array[$key]["user_id"] . '</td>
						<td>' . $marks_array[$key]["first_name"] . '</td>
						<td>' . $marks_array[$key]["last_name"] . '</td>';
					}
					else
					{
						$flag = true;
						$table_body .= '
						<tr>
						<td>' . ++$count . '</td>
						<td><a class="image-popup-no-margins" href="https://vedaiit.org/application/uploads/' . basename($marks_array[$key]['user_image']) . '"><img src="https://vedaiit.org/application/uploads/' . basename($marks_array[$key]['user_image']) . '" onerror="this.onerror=null; this.parentNode.href=this.src=\'images/logo/user.png\'" width="35" height="35" style="margin: -12px 0px -12px 0px;"></a></td>
						<td>' . $marks_array[$key]["user_id"] . '</td>
						<td>' . $marks_array[$key]["first_name"] . '</td>
						<td>' . $marks_array[$key]["last_name"] . '</td>';
					}
					$current_student = $marks_array[$key]["user_sno"];
				}
				$table_body .= '
				<td class="supp-td" ' . ($marks_array[$key]["marks_percentage"] < 50 ? 'style="color:red;"' : '') . '>' . number_format($marks_array[$key]["marks_obtain_r"], 2) . '</td>
				<td class="supp-td" ' . ($marks_array[$key]["marks_percentage"] < 50 ? 'style="color:red;"' : '') . '>' . (!empty($marks_array[$key]["marks_obtain_s"]) ? number_format($marks_array[$key]["marks_obtain_s"], 2) : 'NA') . '</td>
				<td class="highest-td" title="' . $marks_array[$key]["user_id"] . ' ' . $marks_array[$key]["first_name"] . ' ' . $marks_array[$key]["last_name"] . '" ' . ($marks_array[$key]["marks_percentage"] < 50 ? 'style="color:red;"' : '') . '>' . number_format($marks_array[$key]["max_marks"], 2) . '</td>
				<td class="supp-td">' . $marks_array[$key]["pass_date"] . '</td>
				<td class="supp-td"><a href="' . (count(glob('../../images/answer/exam_' . $marks_array[$key]["exam_sno"] . '/*' . $marks_array[$key]["user_id"] . '*')) > 0 ? 'images/answer/' . glob('../../images/answer/exam_' . $marks_array[$key]["exam_sno"] . '/*' . $marks_array[$key]["user_id"] . '*')[0] : 'javascript:void(0)') . '" target="_blank">Result</a></td>';
			}
			$late_leave =  round($marks_array[$key]["total_late"] / 6, 1);
			$total_veda_leave = round(((($late_leave + $marks_array[$key]["veda_leave"] - $marks_array[$key]["od_leave"] - $marks_array[$key]["casual_leave"]) * 2) - min($marks_array[$key]["health_leave"], 6)) < 0 ? 0 : ((($late_leave + $marks_array[$key]["veda_leave"] - $marks_array[$key]["od_leave"] - $marks_array[$key]["casual_leave"]) * 2) - min($marks_array[$key]["health_leave"], 6)));
			$veda_working_days = empty($marks_array[$key]["user_dop_veda"]) ? 'NA' : $vedaFaculty->getWorkingDays($marks_array[$key]["dop_veda"], $marks_array[$key]["user_dop_veda"]);
			$company_doc = empty($marks_array[$key]["user_dop_veda"]) ? 'NA' : (stripos($marks_array[$key]["company_name"], "VEDA") === false ? $vedaFaculty->getNextWorkingDate1($marks_array[$key]["dop_company"], $total_veda_leave + $veda_working_days + 1) : $vedaFaculty->getNextWorkingDate2($marks_array[$key]["dop_company"], $total_veda_leave + $veda_working_days + 1));
			$credit_leave = round(($late_leave + $marks_array[$key]["veda_leave"] - $marks_array[$key]["od_leave"] - $marks_array[$key]["casual_leave"]) >= 0 ? 0 : ($late_leave + $marks_array[$key]["veda_leave"] - $marks_array[$key]["od_leave"] - $marks_array[$key]["casual_leave"]));
			$total_company_leave = ($credit_leave + $marks_array[$key]["extended_days"] + $marks_array[$key]["company_leave"]) <= 0 ? 0 : ($credit_leave + $marks_array[$key]["extended_days"] + $marks_array[$key]["company_leave"]);
			$company_working_days = empty($marks_array[$key]["user_dop_company"]) ? 'NA' : $vedaFaculty->getWorkingDays($marks_array[$key]["dop_company"], $marks_array[$key]["user_dop_company"]);
			$company_doj = empty($marks_array[$key]["user_dop_company"]) ? 'NA' : (stripos($marks_array[$key]["company_name"], "VEDA") === false ? $vedaFaculty->getNextWorkingDate1($company_doc, $total_company_leave + $company_working_days) : $vedaFaculty->getNextWorkingDate2($company_doc, $total_company_leave + $company_working_days));
			$table_body .= '
			<td class="highest-td" title="' . $marks_array[$key]["user_id"] . ' ' . $marks_array[$key]["first_name"] . ' ' . $marks_array[$key]["last_name"] . '">' . number_format($marks_array[$key]["student_total"], 2) . '</td>
			<td class="percentage-td" title="' . $marks_array[$key]["user_id"] . ' ' . $marks_array[$key]["first_name"] . ' ' . $marks_array[$key]["last_name"] . '" ' . ($marks_array[$key]["student_percentage"] < 50 ? 'style="color:red;"' : '') . '>' . $marks_array[$key]["student_percentage"] . '</td>
			<td class="percentage-td">' . ($marks_array[$key]["student_percentage"] < 50 ? 'NI' : ($marks_array[$key]["student_percentage"] < 65 ? 'M' : ($marks_array[$key]["student_percentage"] < 80 ? 'M+' : ($marks_array[$key]["student_percentage"] < 90 ? 'E' : 'O')))) . '</td>
			<td>' . (empty($marks_array[$key]["user_dop_veda"]) ? 'NA' : $marks_array[$key]["user_dop_veda"]) . '</td>
			<td>' . (empty($marks_array[$key]["user_dop_veda"]) ? 'NA' : ($marks_array[$key]["student_percentage"] < 50 ? 'Fail' : (strtotime($marks_array[$key]["user_dop_veda"]) > strtotime($marks_array[$key]["dop_veda"]) ? 'Supp' : 'Pass'))) . '</td>
			<td>' . (empty($marks_array[$key]["user_dop_company"]) ? 'NA' : $marks_array[$key]["user_dop_company"]) . '</td>
			<td>' . (empty($marks_array[$key]["user_dop_company"]) ? 'NA' : (strtotime($marks_array[$key]["user_dop_company"]) > strtotime($marks_array[$key]["dop_company"]) ? 'Supp' : 'Pass')) . '</td>
			<td>' . $marks_array[$key]["user_qualification"] . '</td>
			<td>' . $marks_array[$key]["user_yop"] . '</td>
			<td>' . $marks_array[$key]["company_name"] . '</td>
			<td>' . $marks_array[$key]["training_place"] . '</td>
			<td>' . $marks_array[$key]["work_place"] . '</td>
			<td>' . $marks_array[$key]["training_period"] . '</td>
			<td>' . $marks_array[$key]["bond_amount"] . '</td>
			<td>' . $marks_array[$key]["salary_from"] . '</td>
			<td>' . $marks_array[$key]["salary_to"] . '</td>
			<td>' . $marks_array[$key]["health_leave"] . '</td>
			<td>' . $marks_array[$key]["total_late"] . '</td>
			<td>' . $late_leave . '</td>
			<td>' . $marks_array[$key]["veda_leave"] . '</td>
			<td>' . $marks_array[$key]["od_leave"] . '</td>
			<td>' . $marks_array[$key]["casual_leave"] . '</td>
			<td>' . $total_veda_leave . '</td>
			<td>' . $veda_working_days . '</td>
			<td>' . $company_doc . '</td>
			<td>' . $credit_leave . '</td>
			<td>' . $marks_array[$key]["extended_days"] . '</td>
			<td>' . $marks_array[$key]["company_leave"] . '</td>
			<td>' . $total_company_leave . '</td>
			<td>' . $company_working_days . '</td>
			<td title="' . $marks_array[$key]["user_id"] . ' ' . $marks_array[$key]["first_name"] . ' ' . $marks_array[$key]["last_name"] . '">' . $company_doj . '</td>
			<td title="' . $marks_array[$key]["user_id"] . ' ' . $marks_array[$key]["first_name"] . ' ' . $marks_array[$key]["last_name"] . '">' . (empty($marks_array[$key]["user_dop_company"]) || empty($marks_array[$key]["salary_from"]) || empty($marks_array[$key]["salary_to"]) ? 'NA' : (strtotime($marks_array[$key]["user_dop_company"]) > strtotime($marks_array[$key]["dop_company"]) ? number_format($marks_array[$key]["salary_from"], 2) : (stripos($marks_array[$key]["domain_id"], "AD") === false ? ($marks_array[$key]["student_percentage"] < 65 ? number_format($marks_array[$key]["salary_from"], 2) : ($marks_array[$key]["student_percentage"] < 80 ? number_format($marks_array[$key]["salary_from"] + ((($marks_array[$key]["salary_to"] - $marks_array[$key]["salary_from"]) / 3) * 1), 2) : ($marks_array[$key]["student_percentage"] < 90 ? number_format($marks_array[$key]["salary_from"] + ((($marks_array[$key]["salary_to"] - $marks_array[$key]["salary_from"]) / 3) * 2), 2) : number_format($marks_array[$key]["salary_from"] + ((($marks_array[$key]["salary_to"] - $marks_array[$key]["salary_from"]) / 3) * 3), 2)))) : number_format((($marks_array[$key]["student_percentage"] - 50) / 100) + $marks_array[$key]["salary_from"], 2)))) . '</td>
			<td>' . $marks_array[$key]["user_manager"] . '</td>
			<td>' . $marks_array[$key]["user_remark"] . '</td>
			</tr></tbody>';
			$table_header .= '
			<th class="highest-td" data-sort="float">Total</th>
			<th class="percentage-td" data-sort="int">%Percentage</th>
			<th class="percentage-td" title="O (Outstanding), E (Exceeds Expectations), M+ (Successful Performance), M (Meets Expectations), NI (Needs Improvement)">Result</th>
			<th>DOP in Veda</th>
			<th data-sort="string">Pass/Fail/Supp Veda</th>
			<th>DOP in Company</th>
			<th data-sort="string">Pass/Fail/Supp Company</th>
			<th>Qualification</th>
			<th>YOP</th>
			<th>Company</th>
			<th>Training Place</th>
			<th>Work Place</th>
			<th>Training Batch</th>
			<th>Bond Amount</th>
			<th>Salary From</th>
			<th>Salary To</th>
			<th>Health Leave</th>
			<th>Total Late</th>
			<th title="round(total_late / 6, 1)">Late Leave</th>
			<th>Leave in Veda</th>
			<th>od_leave</th>
			<th>Casual Leave</th>
			<th title="round(((late_leave + veda_leave - od_leave - casual_leave) * 2) - min(health_leave, 6) < 0 ? 0 : ((late_leave + veda_leave - od_leave - casual_leave) * 2) - min(health_leave, 6))">Total Leave in Veda</th>
			<th title="empty(user_dop_veda) ? \'NA\' : getWorkingDays(dop_veda, user_dop_veda)">Extend due to Supp in VEDA</th>
			<th title="empty(user_dop_veda) ? \'NA\' : (company_name == \'VEDA\' ? getNextWorkingDate1(dop_company, $total_veda_leave + $veda_working_days + 1) : getNextWorkingDate2(dop_company, $total_veda_leave + $veda_working_days + 1))">Expected DOC in Company</th>
			<th title="round((late_leave + veda_leave - od_leave - casual_leave) >= 0 ? 0 : (late_leave + veda_leave - od_leave - casual_leave))">Casual Leave Credit</th>
			<th>Extended Days</th>
			<th>Leave in Company</th>
			<th title="(credit_leave + extended_days + company_leave) <= 0 ? 0 : (credit_leave + extended_days + company_leave)">Total Extension in Company</th>
			<th title="empty(user_dop_company) ? \'NA\' : getWorkingDays(dop_company, user_dop_company)">Extended due to performance in Company</th>
			<th title="empty(user_dop_company) ? \'NA\' : (company_name == \'VEDA\' ? getNextWorkingDate1(company_doc, total_company_leave + company_working_days) : getNextWorkingDate2(company_doc, total_company_leave + company_working_days))">DOJ in Company</th>
			<th title="(empty(user_dop_company) || empty(salary_from) || empty(salary_to)) ? \'NA\' : (user_dop_company > dop_company ? salary_from : (domain_id != \'AD\' ? (student_percentage < 65 ? salary_from : (student_percentage < 80 ? salary_from + (((salary_to - salary_from) / 3) * 1) : (student_percentage < 90 ? salary_from + (((salary_to - salary_from) / 3) * 2) : salary_from + (((salary_to - salary_from) / 3) * 3)))) : (((student_percentage - 50) / 100) + salary_from)))">CTC</th>
			<th>Student Manager</th>
			<th>Remark</th>
			</tr>';
			$subject_marks .= '
			<th class="highest-td">' . number_format($marks_array[0]["exam_total"], 2) . '</th>
			<th class="percentage-td">' . number_format(100, 2) . '</th>
			<th class="percentage-td"></th>
			<th>' . $marks_array[0]["dop_veda"] . '</th>
			<th></th>
			<th>' . $marks_array[0]["dop_company"] . '</th>
			<th colspan="28"></th>
			</tr>';
			$result_date .= '<th colspan="34"></th></tr>';
			$exam_date .= '<th colspan="34"></th></tr>';
			$table_top = '<thead>' . $exam_date . $result_date . $subject_marks . $table_header . '</thead>';
			$response['details'] .= $table_top;
			$response['details'] .= $table_body;
			$response['details'] .= '
			</table>
			</div>
			</div>
			</div>
			</div>
			</div>
			<script>
			var clipboard = new ClipboardJS("#copy-btn");
			$("#hide_column").val([".head-tr", ".supp-td"]);
			$(".head-tr, .supp-td").addClass("hidden");
			$(".colspan-td").attr("colspan",1);
			$(".image-popup-no-margins").magnificPopup({
			type: "image",
			closeOnContentClick: true,
			closeBtnInside: false,
			fixedContentPos: true,
			mainClass: "mfp-no-margins mfp-with-zoom",
			image: {
			verticalFit: true
			},
			zoom: {
			enabled: true,
			duration: 300
			}
			});';
			if (isset($_POST['domain_sno']) && count($_POST['domain_sno']) > 1)
			{
				$response['details'] .= '
		    	$("#hide_column").val([".head-tr", ".supp-td", ".highest-td"]);
				$("#hide_column option[value=\'"+ [".head-tr", ".supp-td", ".highest-td"].join("\'],[value=\'") +"\']").attr("disabled","disabled");
				$(".head-tr, .supp-td, .highest-td").addClass("hidden");
				$(".colspan-td").attr("colspan",1);';
			}
			if ($_SESSION['veda_user_type'] == 'HR Veda' || $_SESSION['veda_user_type'] == 'HR Company')
			{
				$response['details'] .= '
		    	$("#hide_column").val([".head-tr", ".supp-td", ".highest-td", ".percentage-td"]);
				$("#hide_column option[value=\'"+ [".head-tr", ".supp-td", ".highest-td", ".percentage-td"].join("\'],[value=\'") +"\']").attr("disabled","disabled");
				$(".head-tr, .supp-td, .highest-td, .percentage-td").addClass("hidden");
				$(".colspan-td").attr("colspan",1);';
			}
			$response['details'] .= '
			table = $("#marks-table").stupidtable();
			table.on("beforetablesort", function (event, data) {
			$("#marks-table").addClass("loading");
			});
			table.on("aftertablesort", function (event, data) {
			$("#marks-table").removeClass("loading");
			var th = $("#marks-table > thead > tr:nth-child(4)").find("th");
			th.find(".arrow").remove();
			var dir = $.fn.stupidtable.dir;
			var arrow = data.direction === dir.ASC ? "&uarr;" : "&darr;";
			th.filter(":visible").eq(data.column).append(\'<span class="arrow">\' + arrow +\'</span>\');
			});

			$(".filter").TableFilter();

			$("#hide_column").multipleSelect({
			placeholder: "Hide Column",
			width: 150,
			dropWidth: 150,
			maxHeight: +10,
			maxHeightUnit: "row",
	        selectAll: false,
			onClick: function(view) {
	    	view["selected"] ? $(view["value"]).addClass("hidden") : $(view["value"]).removeClass("hidden");
			view["value"] == ".supp-td" ? (view["selected"] ? $(".colspan-td").attr("colspan",1) : $(".colspan-td").attr("colspan",3)) : "";
			}
			});

			$("#export-btn").on("click", function() {
			$("#marks-table").table2excel({
			exclude: ".hidden",
			filename: "Result_' . $marks_array[0]["domain_id"] . '_"+new Date().toJSON().slice(0,10).split("-").reverse().join("-")+".xls",
			fileext: ".xls"
			});
			});
			</script>';
			$response['status'] = 'success';
		}
		else
		{
			$response['status'] = 'error';
			$response['message'] = 'Not found any result of student';
		}
	}
	else
	{
		$marks_array = $_SESSION['veda_user_type'] != 'MS' ? $vedaFaculty->getMsMarksByDomainSno(implode(',', $_POST['domain_sno']), $_POST['exam_group']) : '';
		if (!empty($marks_array))
		{
			$email_id = "rajeev.sah006@gmail.com;rajeevkumar.sah@vedaiit.com";
			$cc = "rajeev.sah006@gmail.com;rajeevkumar.sah@vedaiit.com";
			$subject = "Result of " . $marks_array[0]['domain_id'];
			$body = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.%0D%0A %0D%0Aconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.%0D%0A %0D%0ALorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.%0D%0A %0D%0ADuis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
			$response['details'] = '
			<div class="row">
			<div class="col-md-12">
			<div class="card">
			<div class="card-body">
			<div class="row">
			<div class="col-md-6">
			<div class="mb-4" style="display:inline-block;">
			<select id="hide_column" class="form-control form-control-sm" multiple="multiple">
			<option value=".head-tr">Table Head</option>
			<option value=".supp-td">Supp Marks</option>
			<option value=".highest-td">Highest Marks</option>
			<option value=".percentage-td">Percentage</option>
			</select>
			</div>';
			if ($_SESSION['veda_user_type'] != 'MS')
			{
				$response['details'] .= '
				<div style="display:inline-block;margin-left:10px;">
				<button class="btn btn-success btn-sm shadow-none" id="copy-btn" data-clipboard-target="#marks-table"><i class="fas fa-copy"></i>&nbsp;Copy</button>
				</div>
				<div style="display:inline-block;margin-left:10px;">
				<button class="btn btn-danger btn-sm shadow-none" id="export-btn"><i class="fas fa-download"></i>&nbsp;Export</button>
				</div>
				<div style="display:inline-block;margin-left:10px;">
				<a href="mailto:' . $email_id . '?subject=' . $subject . '&body=' . $body . '&cc=' . $cc . '" class="btn btn-info btn-sm shadow-none" id="mail-btn"><i class="fas fa-share"></i>&nbsp;Share</a>
				</div>';
			}
			$response['details'] .= '
			<div style="display:inline-block;margin-left:10px;">
			<a onclick="$(\'#result\').toggleFullScreen()" class="btn shadow-none text-secondary" id="expand-btn"><i class="fas fa-expand-arrows-alt"></i></a>
			</div>
			</div>';
			if ($_SESSION['veda_user_type'] != 'MS')
			{
				$response['details'] .= '
				<div class="col-md-6">
				<label style="float: right;">Search:<input type="search" class="form-control form-control-sm filter" placeholder="Search records" data-tablefilter="#marks-table"></label>
				</div>';
			}
			$response['details'] .= '
			</div>
			<div class="table-responsive">
			<table class="table table-striped table-bordered display nowrap" id="marks-table" width="100%">';
			$exam_date = '
			<tr class="head-tr">
			<th colspan="5">Exam Date</th>';
			$result_date = '
			<tr class="head-tr">
			<th colspan="5">Result Date</th>';
			$subject_marks = '
			<tr class="head-tr">
			<th colspan="5">Subject Marks</th>';
			$table_header = '
			<tr>
			<th data-sort="int" data-sort-default="desc">S.No.</th>
			<th>Image</th>
			<th data-sort="string" data-sort-default="desc">Student Id</th>
			<th data-sort="string" data-sort-default="desc">First Name</th>
			<th data-sort="string">Last Name</th>';
			$table_body = '<tbody>';
			$current_student = "";
			$count = 0;
			$flag = false;
			foreach ($marks_array as $key => $value)
			{
				if ($marks_array[$key]["user_sno"] == $marks_array[0]["user_sno"])
				{
					$exam_date .= '
					<th class="supp-td">' . $marks_array[$key]["exam_date_r"] . '</th>
					<th class="supp-td">' . $marks_array[$key]["exam_date_s"] . '</th>
					<th class="colspan-td highest-td" colspan="3"></th>';
					$result_date .= '
					<th class="supp-td">' . $marks_array[$key]["result_date_r"] . '</th>
					<th class="supp-td">' . $marks_array[$key]["result_date_s"] . '</th>
					<th class="colspan-td highest-td" colspan="3"></th>';
					$subject_marks .= '
					<th class="supp-td">' . $marks_array[$key]["exam_marks"] . '</th>
					<th class="supp-td">' . $marks_array[$key]["exam_marks"] . '</th>
					<th class="colspan-td highest-td" colspan="3"></th>';
					$table_header .= '
					<th class="supp-td" title="' . $marks_array[$key]["subject_name"] . '">' . $marks_array[$key]["subject_code"] . '_' . $marks_array[$key]["exam_type"] . '_R</th>
					<th class="supp-td" title="' . $marks_array[$key]["subject_name"] . '">' . $marks_array[$key]["subject_code"] . '_' . $marks_array[$key]["exam_type"] . '_S</th>
					<th class="highest-td" data-sort="float" title="' . $marks_array[$key]["subject_name"] . '">' . $marks_array[$key]["subject_code"] . '_' . $marks_array[$key]["exam_type"] . '_H</th>
					<th class="supp-td">Pass Date</th>
					<th class="supp-td">Answer</th>';
				}
				if ($marks_array[$key]["user_sno"] != $current_student)
				{
					$flag = true;
					$table_body .= '
					<tr>
					<td>' . ++$count . '</td>
					<td><a class="image-popup-no-margins" href="https://vedaiit.org/application/uploads/' . basename($marks_array[$key]['user_image']) . '"><img src="https://vedaiit.org/application/uploads/' . basename($marks_array[$key]['user_image']) . '" onerror="this.onerror=null; this.parentNode.href=this.src=\'images/logo/user.png\'" width="35" height="35" style="margin: -12px 0px -12px 0px;"></a></td>
					<td>' . $marks_array[$key]["user_id"] . '</td>
					<td>' . $marks_array[$key]["first_name"] . '</td>
					<td>' . $marks_array[$key]["last_name"] . '</td>';
					$current_student = $marks_array[$key]["user_sno"];
				}
				$table_body .= '
				<td class="supp-td">' . $marks_array[$key]["marks_obtain_r"] . '</td>
				<td class="supp-td">' . (!empty($marks_array[$key]["marks_obtain_s"]) ? number_format($marks_array[$key]["marks_obtain_s"], 2) : 'NA') . '</td>
				<td class="highest-td" title="' . $marks_array[$key]["user_id"] . ' ' . $marks_array[$key]["first_name"] . ' ' . $marks_array[$key]["last_name"] . '">' . $marks_array[$key]["max_marks"] . '</td>
				<td class="supp-td">' . $marks_array[$key]["pass_date"] . '</td>
				<td class="supp-td"><a href="' . (count(glob('../../images/answer/exam_' . $marks_array[$key]["exam_sno"] . '/*' . $marks_array[$key]["user_id"] . '*')) > 0 ? 'images/answer/' . glob('../../images/answer/exam_' . $marks_array[$key]["exam_sno"] . '/*' . $marks_array[$key]["user_id"] . '*')[0] : 'javascript:void(0)') . '" target="_blank">Result</a></td>';
			}
			$table_body .= '
			</tr></tbody>';
			$table_header .= '
			</tr>';
			$subject_marks .= '
			</tr>';
			$result_date .= '</tr>';
			$exam_date .= '</tr>';
			$table_top = '<thead>' . $exam_date . $result_date . $subject_marks . $table_header . '</thead>';
			$response['details'] .= $table_top;
			$response['details'] .= $table_body;
			$response['details'] .= '
			</table>
			</div>
			</div>
			</div>
			</div>
			</div>
			<script>
			var clipboard = new ClipboardJS("#copy-btn");
			$("#hide_column").val([".head-tr", ".supp-td"]);
			$(".head-tr, .supp-td").addClass("hidden");
			$(".colspan-td").attr("colspan",1);
			$(".image-popup-no-margins").magnificPopup({
			type: "image",
			closeOnContentClick: true,
			closeBtnInside: false,
			fixedContentPos: true,
			mainClass: "mfp-no-margins mfp-with-zoom",
			image: {
			verticalFit: true
			},
			zoom: {
			enabled: true,
			duration: 300
			}
			});';
			if (isset($_POST['domain_sno']) && count($_POST['domain_sno']) > 1)
			{
				$response['details'] .= '
				$("#hide_column").val([".head-tr", ".supp-td", ".highest-td"]);
				$("#hide_column option[value=\'"+ [".head-tr", ".supp-td", ".highest-td"].join("\'],[value=\'") +"\']").attr("disabled","disabled");
				$(".head-tr, .supp-td, .highest-td").addClass("hidden");
				$(".colspan-td").attr("colspan",1);';
			}
			if ($_SESSION['veda_user_type'] == 'HR Veda' || $_SESSION['veda_user_type'] == 'HR Company')
			{
				$response['details'] .= '
				$("#hide_column").val([".head-tr", ".supp-td", ".highest-td", ".percentage-td"]);
				$("#hide_column option[value=\'"+ [".head-tr", ".supp-td", ".highest-td", ".percentage-td"].join("\'],[value=\'") +"\']").attr("disabled","disabled");
				$(".head-tr, .supp-td, .highest-td, .percentage-td").addClass("hidden");
				$(".colspan-td").attr("colspan",1);';
			}
			$response['details'] .= '
			table = $("#marks-table").stupidtable();
			table.on("beforetablesort", function (event, data) {
			$("#marks-table").addClass("loading");
			});
			table.on("aftertablesort", function (event, data) {
			$("#marks-table").removeClass("loading");
			var th = $("#marks-table > thead > tr:nth-child(4)").find("th");
			th.find(".arrow").remove();
			var dir = $.fn.stupidtable.dir;
			var arrow = data.direction === dir.ASC ? "&uarr;" : "&darr;";
			th.filter(":visible").eq(data.column).append(\'<span class="arrow">\' + arrow +\'</span>\');
			});

			$(".filter").TableFilter();

			$("#hide_column").multipleSelect({
			placeholder: "Hide Column",
			width: 150,
			dropWidth: 150,
			maxHeight: +10,
			maxHeightUnit: "row",
			selectAll: false,
			onClick: function(view) {
			view["selected"] ? $(view["value"]).addClass("hidden") : $(view["value"]).removeClass("hidden");
			view["value"] == ".supp-td" ? (view["selected"] ? $(".colspan-td").attr("colspan",1) : $(".colspan-td").attr("colspan",3)) : "";
			}
			});

			$("#export-btn").on("click", function() {
			$("#marks-table").table2excel({
			exclude: ".hidden",
			filename: "Result_' . $marks_array[0]["domain_id"] . '_"+new Date().toJSON().slice(0,10).split("-").reverse().join("-")+".xls",
			fileext: ".xls"
			});
			});
			</script>';
			$response['status'] = 'success';
		}
		else
		{
			$response['status'] = 'error';
			$response['message'] = 'Not found any result of student';
		}
	}
}
else
{
	$response['status'] = 'error';
	$response['message'] = 'Missing parameters, Try again...';
}
echo json_encode($response);
