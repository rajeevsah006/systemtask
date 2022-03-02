<?php
header('Content-type: application/json');
$response = array();
session_start();
require_once "../class/VedaFaculty.php";
$vedaFaculty = new VedaFaculty();
if (isset($_POST['show_button']))
{
    $marks_array = $vedaFaculty->getMarksByDomainSno(implode(',', $_POST['domain_sno']));
    if (!empty($marks_array))
    {
    	$email_id = "rajeev.sah006@gmail.com;rajeevkumar.sah@vedaiit.com";
    	$cc = "rajeev.sah006@gmail.com;rajeevkumar.sah@vedaiit.com";
    	$subject = "Result of ".$marks_array[0]['domain_id'];
    	$body = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.%0D%0A %0D%0Aconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.%0D%0A %0D%0ALorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.%0D%0A %0D%0ADuis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
        $response['details'] = ' 
		<div class="row">
		<div class="col-md-12">
		<div class="card">
		<div class="card-body">
		<div class="row">
		<div class="col-md-6">
		<div style="display:inline-block;">
		<select id="hide_column" class="form-control form-control-sm" multiple="multiple">
		<option value=".supp-td">Supp Marks</option>
		<option value=".highest-td">Highest Marks</option>
		<option value=".percentage-td">Percentage</option>
		<option value=".head-tr">Table Head</option>
		<option value=".foot-tr">Table Foot</option>
		</select>  
		</div>
		<div style="display:inline-block;margin-left:10px;">
		<button class="btn btn-success btn-sm shadow-none" id="copy-btn" data-clipboard-target="#marks-table"><i class="fas fa-copy"></i>&nbsp;Copy</button>
		</div>
		<div style="display:inline-block;margin-left:10px;">
		<button class="btn btn-danger btn-sm shadow-none" id="export-btn"><i class="fas fa-download"></i>&nbsp;Export</button>
		</div>
		<div style="display:inline-block;margin-left:10px;">
		<a href="mailto:'.$email_id.'?subject='.$subject.'&body='.$body.'&cc='.$cc.'" class="btn btn-info btn-sm shadow-none" id="mail-btn"><i class="fas fa-share"></i>&nbsp;Share</a>
		</div>
		<div style="display:inline-block;margin-left:10px;">
		<a onclick="$(\'#result\').toggleFullScreen()" class="btn shadow-none text-secondary" id="expand-btn"><i class="fas fa-expand-arrows-alt"></i></a>
		</div>
		</div>
		<div class="col-md-6">
		<label style="float: right;">Search:<input type="search" class="form-control form-control-sm filter" placeholder="Search records" data-tablefilter="#marks-table"></label>
		</div>
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
		<th>Student Id</th>
		<th data-sort="string" data-sort-default="desc">First Name</th>
		<th data-sort="string">Last Name</th>';
        $table_body = '<tbody><tr>';
        $current_student = "";
        $count = 0;
        $flag = false;
        $subject_total = 0;
        $student_total = 0;
        $total_total = 0;
        $student_percentage = 0;
        $percentage_total = 0;
        $subject_array = array();
        foreach ($marks_array as $key => $value)
        {
            if ($marks_array[$key]["user_id"] == $marks_array[0]["user_id"])
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
				<th class="supp-td">' . $marks_array[$key]["subject_marks"] . '</th>
				<th class="supp-td">' . $marks_array[$key]["subject_marks"] . '</th>
				<th class="colspan-td highest-td" colspan="3"></th>';
                $table_header .= '
				<th class="supp-td">' . $marks_array[$key]["subject_name"] . '_R</th>
				<th class="supp-td">' . $marks_array[$key]["subject_name"] . '_S</th>
				<th class="highest-td">' . $marks_array[$key]["subject_name"] . '_H</th>
				<th class="supp-td">Pass Date</th>
				<th class="supp-td">Answer</th>';
                $subject_total += $marks_array[$key]["subject_marks"];
                $subject_array[$marks_array[$key]["subject_name"] . '_R'] = array();
                $subject_array[$marks_array[$key]["subject_name"] . '_S'] = array();
                $subject_array[$marks_array[$key]["subject_name"] . '_H'] = array();
            }
            if ($marks_array[$key]["user_id"] != $current_student)
            {
                if ($flag)
                {
                    $total_veda_leave = round(((($marks_array[$key - 1]["total_late"] / 6) + $marks_array[$key - 1]["veda_leave"] - $marks_array[$key - 1]["od"] - $marks_array[$key - 1]["casual_leave"]) * 2) - min($marks_array[$key - 1]["health_leave"], 6) < 0 ? 0 : ((($marks_array[$key - 1]["total_late"] / 6) + $marks_array[$key - 1]["veda_leave"] - $marks_array[$key - 1]["od"] - $marks_array[$key - 1]["casual_leave"]) * 2) - min($marks_array[$key - 1]["health_leave"], 6));
                    $veda_working_days = empty($marks_array[$key - 1]["user_dop_veda"]) ? 'Awaited' : $vedaFaculty->getWorkingDays($marks_array[$key - 1]["dop_veda"], $marks_array[$key - 1]["user_dop_veda"]);
                    $company_doc = empty($marks_array[$key - 1]["user_dop_veda"]) ? 'Awaited' : (stripos($marks_array[$key - 1]["company_name"], "VEDA") === false ? $vedaFaculty->getNextWorkingDate1($marks_array[$key - 1]["dop_company"], $total_veda_leave + $veda_working_days + 1) : $vedaFaculty->getNextWorkingDate2($marks_array[$key - 1]["dop_company"], $total_veda_leave + $veda_working_days + 1));
                    $credit_leave = (($marks_array[$key - 1]["total_late"] / 6) + $marks_array[$key - 1]["veda_leave"] - $marks_array[$key - 1]["od"] - $marks_array[$key - 1]["casual_leave"]) >= 0 ? 0 : (($marks_array[$key - 1]["total_late"] / 6) + $marks_array[$key - 1]["veda_leave"] - $marks_array[$key - 1]["od"] - $marks_array[$key - 1]["casual_leave"]);
                    $total_company_leave = round($credit_leave + $marks_array[$key - 1]["extended_days"] + $marks_array[$key - 1]["company_leave"]) <= 0 ? 0 : round($credit_leave + $marks_array[$key - 1]["extended_days"] + $marks_array[$key - 1]["company_leave"]);
                    $company_working_days = empty($marks_array[$key - 1]["user_dop_company"]) ? 'Awaited' : $vedaFaculty->getWorkingDays($marks_array[$key - 1]["dop_company"], $marks_array[$key - 1]["user_dop_company"]);
                    $company_doj = empty($marks_array[$key - 1]["user_dop_company"]) ? 'Awaited' : (stripos($marks_array[$key - 1]["company_name"], "VEDA") === false ? $vedaFaculty->getNextWorkingDate1($company_doc, $total_company_leave + $company_working_days) : $vedaFaculty->getNextWorkingDate2($company_doc, $total_company_leave + $company_working_days));
                    $student_percentage = round(($student_total / $subject_total) * 100);
                    $table_body .= '
					<td class="highest-td">' . number_format($student_total, 2) . '</td>
					<td class="percentage-td" title="' . $marks_array[$key - 1]["user_id"] . ' ' . $marks_array[$key - 1]["first_name"] . ' ' . $marks_array[$key - 1]["last_name"] . '">' . $student_percentage . '</td>
					<td class="percentage-td">' . ($student_percentage < 50 ? 'F' : ($student_percentage < 65 ? 'A' : ($student_percentage < 80 ? 'A+' : ($student_percentage < 90 ? 'E' : 'O')))) . '</td>
					<td>' . $marks_array[$key - 1]["user_dop_veda"] . '</td>
					<td>' . (empty($marks_array[$key - 1]["user_dop_veda"]) ? 'Awaited' : ($student_percentage < 50 ? 'Fail' : (strtotime($marks_array[$key - 1]["user_dop_veda"]) > strtotime($marks_array[$key - 1]["dop_veda"]) ? 'Supp' : 'Pass'))) . '</td>
					<td>' . $marks_array[$key - 1]["user_dop_company"] . '</td>
					<td>' . (empty($marks_array[$key - 1]["user_dop_company"]) ? 'Awaited' : (strtotime($marks_array[$key - 1]["user_dop_company"]) > strtotime($marks_array[$key - 1]["dop_company"]) ? 'Supp' : 'Pass')) . '</td>
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
					<td>' . round($marks_array[$key - 1]["total_late"] / 6, 1) . '</td>
					<td>' . $marks_array[$key - 1]["veda_leave"] . '</td>
					<td>' . $marks_array[$key - 1]["od"] . '</td>
					<td>' . $marks_array[$key - 1]["casual_leave"] . '</td>
					<td>' . $total_veda_leave . '</td>
					<td>' . $veda_working_days . '</td>
					<td>' . $company_doc . '</td>
					<td>' . round($credit_leave, 1) . '</td>
					<td>' . $marks_array[$key - 1]["extended_days"] . '</td>
					<td>' . $marks_array[$key - 1]["company_leave"] . '</td>
					<td>' . $total_company_leave . '</td>
					<td>' . $company_working_days . '</td>
					<td>' . $company_doj . '</td>
					<td title="' . $student_percentage . '">' . (empty($marks_array[$key - 1]["user_dop_company"]) || empty($marks_array[$key - 1]["salary_from"]) || empty($marks_array[$key - 1]["salary_to"]) ? 'Awaited' : (strtotime($marks_array[$key - 1]["user_dop_company"]) > strtotime($marks_array[$key - 1]["dop_company"]) ? number_format($marks_array[$key - 1]["salary_from"], 2) : (stripos($marks_array[$key - 1]["domain_id"], "AD") === false ? ($student_percentage < 65 ? number_format($marks_array[$key - 1]["salary_from"], 2) : ($student_percentage < 80 ? number_format($marks_array[$key - 1]["salary_from"] + ((($marks_array[$key - 1]["salary_to"] - $marks_array[$key - 1]["salary_from"]) / 3) * 1), 2) : ($student_percentage < 90 ? number_format($marks_array[$key - 1]["salary_from"] + ((($marks_array[$key - 1]["salary_to"] - $marks_array[$key - 1]["salary_from"]) / 3) * 2), 2) : number_format($marks_array[$key - 1]["salary_from"] + ((($marks_array[$key - 1]["salary_to"] - $marks_array[$key - 1]["salary_from"]) / 3) * 3), 2)))) : number_format((($student_percentage - 50) / 100) + $marks_array[$key - 1]["salary_from"], 2)))) . '</td>
					<td>' . $marks_array[$key - 1]["user_manager"] . '</td>
					<td>' . $marks_array[$key - 1]["user_remark"] . '</td>
					</tr><tr>
					<td>' . ++$count . '</td>
					<td><a class="image-popup-no-margins" href="https://vedaiit.org/application/uploads/' . basename($marks_array[$key]['user_image']) . '"><img src="https://vedaiit.org/application/uploads/' . basename($marks_array[$key]['user_image']) . '" onerror="this.onerror=null; this.src=\'images/logo/user.png\'" width="35" height="35" style="margin: -12px 0px -12px 0px;"></a></td>
					<td>' . $marks_array[$key]["user_id"] . '</td>
					<td>' . $marks_array[$key]["first_name"] . '</td>
					<td>' . $marks_array[$key]["last_name"] . '</td>';
                }
                else
                {
                	$flag = true;
                    $table_body .= '
					</tr><tr>
					<td>' . ++$count . '</td>
					<td><a class="image-popup-no-margins" href="https://vedaiit.org/application/uploads/' . basename($marks_array[$key]['user_image']) . '"><img src="https://vedaiit.org/application/uploads/' . basename($marks_array[$key]['user_image']) . '" onerror="this.onerror=null; this.src=\'images/logo/user.png\'" width="35" height="35" style="margin: -12px 0px -12px 0px;"></a></td>
					<td>' . $marks_array[$key]["user_id"] . '</td>
					<td>' . $marks_array[$key]["first_name"] . '</td>
					<td>' . $marks_array[$key]["last_name"] . '</td>';
                }
                $current_student = $marks_array[$key]["user_id"];
                $total_total += $student_total;
                $percentage_total += ($student_total / $subject_total) * 100;
                $student_total = 0;
                $student_percentage = 0;
            }
			$table_body .= '
			<td class="supp-td" ' . ($marks_array[$key]["marks_percentage"] < 50 ? 'style="color:red;"' : '') . '>' . number_format($marks_array[$key]["marks_obtain_r"], 2) . '</td>
			<td class="supp-td" ' . ($marks_array[$key]["marks_percentage"] < 50 ? 'style="color:red;"' : '') . '>' . (!empty($marks_array[$key]["marks_obtain_s"]) ? number_format($marks_array[$key]["marks_obtain_s"], 2) : 'Unattend') . '</td>
			<td class="highest-td" title="' . $marks_array[$key]["user_id"] . ' ' . $marks_array[$key]["first_name"] . ' ' . $marks_array[$key]["last_name"] . '" ' . ($marks_array[$key]["marks_percentage"] < 50 ? 'style="color:red;"' : '') . '>' . number_format($marks_array[$key]["max_marks"], 2) . '</td>
			<td class="supp-td">' . $marks_array[$key]["pass_date"] . '</td>
			<td class="supp-td"><a href="' . (count(glob('../../images/answer/exam_' . $marks_array[$key]["exam_sno"] . '/*' . $marks_array[$key]["user_id"] . '*')) > 0 ? 'images/answer/' . glob('../../images/answer/exam_' . $marks_array[$key]["exam_sno"] . '/*' . $marks_array[$key]["user_id"] . '*')[0] : 'javascript:void(0)') . '" target="_blank">Result</a></td>';	
            $student_total += $marks_array[$key]["max_marks"];
            $subject_array[$marks_array[$key]["subject_name"] . '_R'][] = $marks_array[$key]["marks_obtain_r"];
            $subject_array[$marks_array[$key]["subject_name"] . '_S'][] = !empty($marks_array[$key]["marks_obtain_s"]) ? $marks_array[$key]["marks_obtain_s"] : 0;
            $subject_array[$marks_array[$key]["subject_name"] . '_H'][] = $marks_array[$key]["max_marks"];
        }
        $total_total += $student_total;
        $percentage_total += ($student_total / $subject_total) * 100;
        $total_veda_leave = round(((($marks_array[$key]["total_late"] / 6) + $marks_array[$key]["veda_leave"] - $marks_array[$key]["od"] - $marks_array[$key]["casual_leave"]) * 2) - min($marks_array[$key]["health_leave"], 6) < 0 ? 0 : ((($marks_array[$key]["total_late"] / 6) + $marks_array[$key]["veda_leave"] - $marks_array[$key]["od"] - $marks_array[$key]["casual_leave"]) * 2) - min($marks_array[$key]["health_leave"], 6));
        $veda_working_days = empty($marks_array[$key]["user_dop_veda"]) ? 'Awaited' : $vedaFaculty->getWorkingDays($marks_array[$key]["dop_veda"], $marks_array[$key]["user_dop_veda"]);
        $company_doc = empty($marks_array[$key]["user_dop_veda"]) ? 'Awaited' : (stripos($marks_array[$key]["company_name"], "VEDA") === false ? $vedaFaculty->getNextWorkingDate1($marks_array[$key]["dop_company"], $total_veda_leave + $veda_working_days + 1) : $vedaFaculty->getNextWorkingDate2($marks_array[$key]["dop_company"], $total_veda_leave + $veda_working_days + 1));
        $credit_leave = (($marks_array[$key]["total_late"] / 6) + $marks_array[$key]["veda_leave"] - $marks_array[$key]["od"] - $marks_array[$key]["casual_leave"]) >= 0 ? 0 : (($marks_array[$key]["total_late"] / 6) + $marks_array[$key]["veda_leave"] - $marks_array[$key]["od"] - $marks_array[$key]["casual_leave"]);
        $total_company_leave = round($credit_leave + $marks_array[$key]["extended_days"] + $marks_array[$key]["company_leave"]) <= 0 ? 0 : round($credit_leave + $marks_array[$key]["extended_days"] + $marks_array[$key]["company_leave"]);
        $company_working_days = empty($marks_array[$key]["user_dop_company"]) ? 'Awaited' : $vedaFaculty->getWorkingDays($marks_array[$key]["dop_company"], $marks_array[$key]["user_dop_company"]);
        $company_doj = empty($marks_array[$key]["user_dop_company"]) ? 'Awaited' : (stripos($marks_array[$key]["company_name"], "VEDA") === false ? $vedaFaculty->getNextWorkingDate1($company_doc, $total_company_leave + $company_working_days) : $vedaFaculty->getNextWorkingDate2($company_doc, $total_company_leave + $company_working_days));
        $student_percentage = round(($student_total / $subject_total) * 100);
        $table_body .= '
		<td class="highest-td">' . number_format($student_total, 2) . '</td>
		<td class="percentage-td" title="' . $marks_array[$key]["user_id"] . ' ' . $marks_array[$key]["first_name"] . ' ' . $marks_array[$key]["last_name"] . '">' . $student_percentage . '</td>
		<td class="percentage-td">' . ($student_percentage < 50 ? 'F' : ($student_percentage < 65 ? 'A' : ($student_percentage < 80 ? 'A+' : ($student_percentage < 90 ? 'E' : 'O')))) . '</td>
		<td>' . $marks_array[$key]["user_dop_veda"] . '</td>
		<td>' . (empty($marks_array[$key]["user_dop_veda"]) ? 'Awaited' : ($student_percentage < 50 ? 'Fail' : (strtotime($marks_array[$key]["user_dop_veda"]) > strtotime($marks_array[$key]["dop_veda"]) ? 'Supp' : 'Pass'))) . '</td>
		<td>' . $marks_array[$key]["user_dop_company"] . '</td>
		<td>' . (empty($marks_array[$key]["user_dop_company"]) ? 'Awaited' : (strtotime($marks_array[$key]["user_dop_company"]) > strtotime($marks_array[$key]["dop_company"]) ? 'Supp' : 'Pass')) . '</td>
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
		<td>' . round($marks_array[$key]["total_late"] / 6, 1) . '</td>
		<td>' . $marks_array[$key]["veda_leave"] . '</td>
		<td>' . $marks_array[$key]["od"] . '</td>
		<td>' . $marks_array[$key]["casual_leave"] . '</td>
		<td>' . $total_veda_leave . '</td>
		<td>' . $veda_working_days . '</td>
		<td>' . $company_doc . '</td>
		<td>' . round($credit_leave, 1) . '</td>
		<td>' . $marks_array[$key]["extended_days"] . '</td>
		<td>' . $marks_array[$key]["company_leave"] . '</td>
		<td>' . $total_company_leave . '</td>
		<td>' . $company_working_days . '</td>
		<td>' . $company_doj . '</td>
		<td title="' . $student_percentage . '">' . (empty($marks_array[$key]["user_dop_company"]) || empty($marks_array[$key]["salary_from"]) || empty($marks_array[$key]["salary_to"]) ? 'Awaited' : (strtotime($marks_array[$key]["user_dop_company"]) > strtotime($marks_array[$key]["dop_company"]) ? number_format($marks_array[$key]["salary_from"], 2) : (stripos($marks_array[$key]["domain_id"], "AD") === false ? ($student_percentage < 65 ? number_format($marks_array[$key]["salary_from"], 2) : ($student_percentage < 80 ? number_format($marks_array[$key]["salary_from"] + ((($marks_array[$key]["salary_to"] - $marks_array[$key]["salary_from"]) / 3) * 1), 2) : ($student_percentage < 90 ? number_format($marks_array[$key]["salary_from"] + ((($marks_array[$key]["salary_to"] - $marks_array[$key]["salary_from"]) / 3) * 2), 2) : number_format($marks_array[$key]["salary_from"] + ((($marks_array[$key]["salary_to"] - $marks_array[$key]["salary_from"]) / 3) * 3), 2)))) : number_format((($student_percentage - 50) / 100) + $marks_array[$key]["salary_from"], 2)))) . '</td>
		<td>' . $marks_array[$key]["user_manager"] . '</td>
		<td>' . $marks_array[$key]["user_remark"] . '</td>
		</tr></tbody>';
		$table_header .= '
		<th class="highest-td">Total</th>
		<th class="percentage-td" data-sort="int">%Percentage</th>
		<th class="percentage-td">Result</th>
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
		<th>Late Leave</th>
		<th>Leave in Veda</th>
		<th>OD</th>
		<th>Casual Leave</th>
		<th>Total Leave in Veda</th>
		<th>Extend due to Supp in VEDA</th>
		<th>Expected DOC in Company</th>
		<th>Casual Leave Credit</th>
		<th>Extended Days</th>
		<th>Leave in Company</th>
		<th>Total Extension in Company</th>
		<th>Extended due to performance in Company</th>
		<th>DOJ in Company</th>
		<th>CTC</th>
		<th>Student Manager</th>
		<th>Remark</th>
		</tr>';
        $subject_marks .= '
		<th class="highest-td">' . number_format($subject_total, 2) . '</th>
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
        $table_footer = '<tfoot><tr class="foot-tr"><td colspan="5">Average Marks</td>';
        $tmp = 1;
        foreach ($subject_array as $key => $subject)
        {
            if ($tmp % 3 != 0)
            {
                $table_footer .= '<td class="supp-td">' . number_format(eval('return ' . join('+', $subject) . ';') / $count, 2) . '</td>';
            }
            else
            {
                $table_footer .= '<td class="highest-td">' . number_format(eval('return ' . join('+', $subject) . ';') / $count, 2) . '</td><td class="supp-td"></td><td class="supp-td"></td>';
            }
            $tmp++;
        }
        $table_footer .= '
		<td class="highest-td">' . number_format($total_total / $count, 2) . '</td>
		<td class="percentage-td">' . round($percentage_total / $count) . '</td>
		<td colspan="32"></td>
		</tr></tfoot>';
        $response['details'] .= $table_top;
        $response['details'] .= $table_body;
        $response['details'] .= $table_footer;
        $response['details'] .= '
		</table>
		</div>
		</div>
		</div>
		</div>
		</div>
		<script>
		$("#marks-table > tbody > tr:first-child").remove();
		var clipboard = new ClipboardJS("#copy-btn");
		$("#hide_column").val(".supp-td");
		$(".supp-td").addClass("hidden");
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
		if (count($_POST['domain_sno']) > 1) 
		{
			$response['details'] .= '
			$.each([".supp-td", ".highest-td", ".head-tr", ".foot-tr"], function( index, value ) {
			$("#hide_column option[value=\'"+value+"\']").attr("selected","selected");
			$("#hide_column option[value=\'"+value+"\']").attr("disabled","disabled");
			$(value).addClass("hidden");
			});
			$(".colspan-td").attr("colspan",1);
			';
		}
		if ($_SESSION['veda_account_type'] == 'HR Veda' || $_SESSION['veda_account_type'] == 'HR Company') 
		{ 
			$response['details'] .= '
			$.each([".supp-td", ".highest-td", ".percentage-td", ".head-tr", ".foot-tr"], function( index, value ) {
			$("#hide_column option[value=\'"+value+"\']").attr("selected","selected");
			$("#hide_column option[value=\'"+value+"\']").attr("disabled","disabled");
			$(value).addClass("hidden");
			});
			$(".colspan-td").attr("colspan",1);
			';
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
		filename: "Result_'. $marks_array[0]["domain_id"] .'_"+new Date().toJSON().slice(0,10).split("-").reverse().join("-")+".xls", 
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
    $response['status'] = 'error';
    $response['message'] = 'Missing parameters, Try again...';
}
echo json_encode($response);
?>