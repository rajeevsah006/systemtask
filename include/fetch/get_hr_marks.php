<?php
header('Content-type: application/json');
$response = array();
session_start();
require_once "../class/VedaFaculty.php";
$vedaFaculty = new VedaFaculty();

if (isset($_POST['show_button'])) {
$check_permission = $vedaFaculty->isHrPermissionAvailable($_SESSION['veda_user_sno']);
if (empty($check_permission))
{


$marks_array = $vedaFaculty->getMarksByDomainSno($_POST['domain_sno']);
if (! empty($marks_array)) {
$response['details'] = ' 
<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-body">
<div class="card-content table-responsive text-nowrap">
<table class="table table-striped table-bordered" id="marks-table">';
$exam_date = '
<tr>
<th colspan="4">Exam Date</th>';
$result_date = '
<tr>
<th colspan="4">Result Date</th>';
$subject_marks = '
<tr>
<th colspan="4">Subject Marks</th>';
$table_header = '
<thead>
<tr>
<th>S.No.</th>
<th>Student Id</th>
<th>First Name</th>
<th>Last Name</th>';
$table_data = '<tbody><tr>';
$current_student = "";
$count = 0;
$subject_total = 0;
$student_total = 0;
$total_total = 0;
$student_percentage = 0;
$percentage_total = 0;
$subject_array = array();
foreach ($marks_array as $key => $value) { 
if($marks_array[$key]["user_id"] == $marks_array[0]["user_id"]){
$exam_date .= '
<th>'.$marks_array[$key]["exam_date_r"].'</th>
<th>'.(!empty($marks_array[$key]["exam_date_s"]) ? $marks_array[$key]["exam_date_s"] : 'Not Disclosed').'</th>
<th colspan="3"></th>';
$result_date .= '
<th>'.$marks_array[$key]["result_date_r"].'</th>
<th>'.(!empty($marks_array[$key]["result_date_s"]) ? $marks_array[$key]["result_date_s"] : 'Not Disclosed').'</th>
<th colspan="3"></th>';
$subject_marks .= '
<th>'.$marks_array[$key]["subject_marks"].'</th>
<th>'.$marks_array[$key]["subject_marks"].'</th>
<th colspan="3"></th>';
$table_header .= '
<th>'.$marks_array[$key]["subject_name"].'_R</th>
<th>'.$marks_array[$key]["subject_name"].'_S</th>
<th>'.$marks_array[$key]["subject_name"].'_H</th>
<th>Pass Date</th>
<th>Answer Sheet</th>';
$subject_total += $marks_array[$key]["subject_marks"];
$subject_array[$marks_array[$key]["subject_name"].'_R'] = array();
$subject_array[$marks_array[$key]["subject_name"].'_S'] = array();
$subject_array[$marks_array[$key]["subject_name"].'_H'] = array();
}
if($marks_array[$key]["user_id"] != $current_student){	
if($count != 0) {
$total_veda_leave = round(((($marks_array[$key-1]["total_late"]/6)+$marks_array[$key-1]["veda_leave"]-$marks_array[$key-1]["od"]-$marks_array[$key-1]["casual_leave"])*2)-min($marks_array[$key-1]["health_leave"], 6) < 0 ? 0 : ((($marks_array[$key-1]["total_late"]/6)+$marks_array[$key-1]["veda_leave"]-$marks_array[$key-1]["od"]-$marks_array[$key-1]["casual_leave"])*2)-min($marks_array[$key-1]["health_leave"], 6));
$veda_working_days = empty($marks_array[$key-1]["student_dop_veda"]) ? 'Awaited' : $vedaFaculty->getWorkingDays($marks_array[$key-1]["dop_veda"], $marks_array[$key-1]["student_dop_veda"]);
$company_doc = empty($marks_array[$key-1]["student_dop_veda"]) ? 'Awaited' : (stripos($marks_array[$key-1]["company_name"], "VEDA") === false ? $vedaFaculty->getNextWorkingDate1($marks_array[$key-1]["dop_company"], $total_veda_leave+$veda_working_days+1) : $vedaFaculty->getNextWorkingDate2($marks_array[$key-1]["dop_company"], $total_veda_leave+$veda_working_days+1));
$credit_leave = (($marks_array[$key-1]["total_late"]/6)+$marks_array[$key-1]["veda_leave"]-$marks_array[$key-1]["od"]-$marks_array[$key-1]["casual_leave"]) >= 0 ? 0 : (($marks_array[$key-1]["total_late"]/6)+$marks_array[$key-1]["veda_leave"]-$marks_array[$key-1]["od"]-$marks_array[$key-1]["casual_leave"]);
$total_company_leave = round($credit_leave+$marks_array[$key-1]["extended_day"]+$marks_array[$key-1]["company_leave"]) <= 0 ? 0 : round($credit_leave+$marks_array[$key-1]["extended_day"]+$marks_array[$key-1]["company_leave"]);
$company_working_days = empty($marks_array[$key-1]["student_dop_company"]) ? 'Awaited' : $vedaFaculty->getWorkingDays($marks_array[$key-1]["dop_company"], $marks_array[$key-1]["student_dop_company"]);
$company_doj = empty($marks_array[$key-1]["student_dop_company"]) ? 'Awaited' : (stripos($marks_array[$key-1]["company_name"], "VEDA") === false ? $vedaFaculty->getNextWorkingDate1($company_doc, $total_company_leave+$company_working_days) : $vedaFaculty->getNextWorkingDate2($company_doc, $total_company_leave+$company_working_days));
$student_percentage = round(($student_total/$subject_total)*100);
$table_data .= '
<td>'.number_format($student_total, 2).'</td>
<td>'.$student_percentage.'</td>
<td>'.($student_percentage < 50 ? 'Fail' : ($student_percentage < 65 ? 'Pass' : ($student_percentage < 80 ? 'Good' : ($student_percentage < 90 ? 'Very Good' : 'Excellent')))).'</td>
<td>'.$marks_array[$key-1]["student_dop_veda"].'</td>
<td>'.(empty($marks_array[$key-1]["student_dop_veda"]) ? 'Awaited' : ($student_percentage < 50 ? 'Fail' : (strtotime($marks_array[$key-1]["student_dop_veda"]) > strtotime($marks_array[$key-1]["dop_veda"]) ? 'Supp' : 'Pass'))).'</td>
<td>'.$marks_array[$key-1]["student_dop_company"].'</td>
<td>'.(empty($marks_array[$key-1]["student_dop_company"]) ? 'Awaited' : (strtotime($marks_array[$key-1]["student_dop_company"]) > strtotime($marks_array[$key-1]["dop_company"]) ? 'Supp' : 'Pass')).'</td>
<td>'.$marks_array[$key-1]["student_qualification"].'</td>
<td>'.$marks_array[$key-1]["student_yop"].'</td>
<td>'.$marks_array[$key-1]["company_name"].'</td>
<td>'.$marks_array[$key-1]["training_place"].'</td>
<td>'.$marks_array[$key-1]["work_place"].'</td>
<td>'.$marks_array[$key-1]["training_period"].'</td>
<td>'.$marks_array[$key-1]["bond_amount"].'</td>
<td>'.$marks_array[$key-1]["salary_from"].'</td>
<td>'.$marks_array[$key-1]["salary_to"].'</td>
<td>'.$marks_array[$key-1]["health_leave"].'</td>
<td>'.$marks_array[$key-1]["total_late"].'</td>
<td>'.round($marks_array[$key-1]["total_late"]/6, 1).'</td>
<td>'.$marks_array[$key-1]["veda_leave"].'</td>
<td>'.$marks_array[$key-1]["od"].'</td>
<td>'.$marks_array[$key-1]["casual_leave"].'</td>
<td>'.$total_veda_leave.'</td>
<td>'.$veda_working_days.'</td>
<td>'.$company_doc.'</td>
<td>'.round($credit_leave, 1).'</td>
<td>'.$marks_array[$key-1]["extended_day"].'</td>
<td>'.$marks_array[$key-1]["company_leave"].'</td>
<td>'.$total_company_leave.'</td>
<td>'.$company_working_days.'</td>
<td>'.$company_doj.'</td>
<td>'.(empty($marks_array[$key-1]["student_dop_company"]) || empty($marks_array[$key-1]["salary_from"]) || empty($marks_array[$key-1]["salary_to"]) ? 'Awaited' : (strtotime($marks_array[$key-1]["student_dop_company"]) > strtotime($marks_array[$key-1]["dop_company"]) ? number_format($marks_array[$key-1]["salary_from"], 2) : (stripos($marks_array[$key-1]["domain_id"], "AD") === false ? ($student_percentage < 65 ? number_format($marks_array[$key-1]["salary_from"], 2) : ($student_percentage < 80 ? number_format($marks_array[$key-1]["salary_from"]+((($marks_array[$key-1]["salary_to"]-$marks_array[$key-1]["salary_from"])/3)*1), 2) : ($student_percentage < 90 ? number_format($marks_array[$key-1]["salary_from"]+((($marks_array[$key-1]["salary_to"]-$marks_array[$key-1]["salary_from"])/3)*2), 2) : number_format($marks_array[$key-1]["salary_from"]+((($marks_array[$key-1]["salary_to"]-$marks_array[$key-1]["salary_from"])/3)*3), 2)))) : number_format((($student_percentage-50)/100)+$marks_array[$key-1]["salary_from"], 2)))).'</td>
<td>'.$marks_array[$key-1]["student_manager"].'</td>
<td>'.$marks_array[$key-1]["student_remark"].'</td>
</tr><tr>
<td>'.++$count.'</td><td>'.$marks_array[$key]["user_id"].'</td>
<td>'.$marks_array[$key]["first_name"].'</td>
<td>'.$marks_array[$key]["last_name"].'</td>';	
} else {
$table_data .= '
</tr><tr>
<td>'.++$count.'</td><td>'.$marks_array[$key]["user_id"].'</td>
<td>'.$marks_array[$key]["first_name"].'</td>
<td>'.$marks_array[$key]["last_name"].'</td>';
}
$current_student = $marks_array[$key]["user_id"];
$total_total += $student_total;
$percentage_total += ($student_total/$subject_total)*100;
$student_total = 0;
$student_percentage = 0;
}
$table_data .= '
<td>'.number_format($marks_array[$key]["marks_obtain_r"], 2).'</td>
<td>'.(!empty($marks_array[$key]["marks_obtain_s"]) ? number_format($marks_array[$key]["marks_obtain_s"], 2) : 'Unattend').'</td>
<td>'.number_format($marks_array[$key]["max_marks"], 2).'</td>
<td>'.$marks_array[$key]["pass_date"].'</td>
<td><a href="'.(count(glob('../../images/answer/exam_'.$marks_array[$key]["exam_sno"].'/*'.$marks_array[$key]["user_id"].'*')) > 0 ? 'images/answer/'.glob('../../images/answer/exam_'.$marks_array[$key]["exam_sno"].'/*'.$marks_array[$key]["user_id"].'*')[0] : 'javascript:void(0)').'" target="_blank">Result</a></td>';
$student_total += $marks_array[$key]["max_marks"];
$subject_array[$marks_array[$key]["subject_name"].'_R'][] = $marks_array[$key]["marks_obtain_r"];
$subject_array[$marks_array[$key]["subject_name"].'_S'][] = !empty($marks_array[$key]["marks_obtain_s"]) ? $marks_array[$key]["marks_obtain_s"] : 0;
$subject_array[$marks_array[$key]["subject_name"].'_H'][] = $marks_array[$key]["max_marks"];
}
$total_total += $student_total;
$percentage_total += ($student_total/$subject_total)*100;
$total_veda_leave = round(((($marks_array[$key]["total_late"]/6)+$marks_array[$key]["veda_leave"]-$marks_array[$key]["od"]-$marks_array[$key]["casual_leave"])*2)-min($marks_array[$key]["health_leave"], 6) < 0 ? 0 : ((($marks_array[$key]["total_late"]/6)+$marks_array[$key]["veda_leave"]-$marks_array[$key]["od"]-$marks_array[$key]["casual_leave"])*2)-min($marks_array[$key]["health_leave"], 6));
$veda_working_days = empty($marks_array[$key]["student_dop_veda"]) ? 'Awaited' : $vedaFaculty->getWorkingDays($marks_array[$key]["dop_veda"], $marks_array[$key]["student_dop_veda"]);
$company_doc = empty($marks_array[$key]["student_dop_veda"]) ? 'Awaited' : (stripos($marks_array[$key]["company_name"], "VEDA") === false ? $vedaFaculty->getNextWorkingDate1($marks_array[$key]["dop_company"], $total_veda_leave+$veda_working_days+1) : $vedaFaculty->getNextWorkingDate2($marks_array[$key]["dop_company"], $total_veda_leave+$veda_working_days+1));
$credit_leave = (($marks_array[$key]["total_late"]/6)+$marks_array[$key]["veda_leave"]-$marks_array[$key]["od"]-$marks_array[$key]["casual_leave"]) >= 0 ? 0 : (($marks_array[$key]["total_late"]/6)+$marks_array[$key]["veda_leave"]-$marks_array[$key]["od"]-$marks_array[$key]["casual_leave"]);
$total_company_leave = round($credit_leave+$marks_array[$key]["extended_day"]+$marks_array[$key]["company_leave"]) <= 0 ? 0 : round($credit_leave+$marks_array[$key]["extended_day"]+$marks_array[$key]["company_leave"]);
$company_working_days = empty($marks_array[$key]["student_dop_company"]) ? 'Awaited' : $vedaFaculty->getWorkingDays($marks_array[$key]["dop_company"], $marks_array[$key]["student_dop_company"]);
$company_doj = empty($marks_array[$key]["student_dop_company"]) ? 'Awaited' : (stripos($marks_array[$key]["company_name"], "VEDA") === false ? $vedaFaculty->getNextWorkingDate1($company_doc, $total_company_leave+$company_working_days) : $vedaFaculty->getNextWorkingDate2($company_doc, $total_company_leave+$company_working_days));
$student_percentage = round(($student_total/$subject_total)*100);
$table_data .= '
<td>'.number_format($student_total, 2).'</td>
<td>'.$student_percentage.'</td>
<td>'.($student_percentage < 50 ? 'Fail' : ($student_percentage < 65 ? 'Pass' : ($student_percentage < 80 ? 'Good' : ($student_percentage < 90 ? 'Very Good' : 'Excellent')))).'</td>
<td>'.$marks_array[$key]["student_dop_veda"].'</td>
<td>'.(empty($marks_array[$key]["student_dop_veda"]) ? 'Awaited' : ($student_percentage < 50 ? 'Fail' : (strtotime($marks_array[$key]["student_dop_veda"]) > strtotime($marks_array[$key]["dop_veda"]) ? 'Supp' : 'Pass'))).'</td>
<td>'.$marks_array[$key]["student_dop_company"].'</td>
<td>'.(empty($marks_array[$key]["student_dop_company"]) ? 'Awaited' : (strtotime($marks_array[$key]["student_dop_company"]) > strtotime($marks_array[$key]["dop_company"]) ? 'Supp' : 'Pass')).'</td>
<td>'.$marks_array[$key]["student_qualification"].'</td>
<td>'.$marks_array[$key]["student_yop"].'</td>
<td>'.$marks_array[$key]["company_name"].'</td>
<td>'.$marks_array[$key]["training_place"].'</td>
<td>'.$marks_array[$key]["work_place"].'</td>
<td>'.$marks_array[$key]["training_period"].'</td>
<td>'.$marks_array[$key]["bond_amount"].'</td>
<td>'.$marks_array[$key]["salary_from"].'</td>
<td>'.$marks_array[$key]["salary_to"].'</td>
<td>'.$marks_array[$key]["health_leave"].'</td>
<td>'.$marks_array[$key]["total_late"].'</td>
<td>'.round($marks_array[$key]["total_late"]/6, 1).'</td>
<td>'.$marks_array[$key]["veda_leave"].'</td>
<td>'.$marks_array[$key]["od"].'</td>
<td>'.$marks_array[$key]["casual_leave"].'</td>
<td>'.$total_veda_leave.'</td>
<td>'.$veda_working_days.'</td>
<td>'.$company_doc.'</td>
<td>'.round($credit_leave, 1).'</td>
<td>'.$marks_array[$key]["extended_day"].'</td>
<td>'.$marks_array[$key]["company_leave"].'</td>
<td>'.$total_company_leave.'</td>
<td>'.$company_working_days.'</td>
<td>'.$company_doj.'</td>
<td>'.(empty($marks_array[$key]["student_dop_company"]) || empty($marks_array[$key]["salary_from"]) || empty($marks_array[$key]["salary_to"]) ? 'Awaited' : (strtotime($marks_array[$key]["student_dop_company"]) > strtotime($marks_array[$key]["dop_company"]) ? number_format($marks_array[$key]["salary_from"], 2) : (stripos($marks_array[$key]["domain_id"], "AD") === false ? ($student_percentage < 65 ? number_format($marks_array[$key]["salary_from"], 2) : ($student_percentage < 80 ? number_format($marks_array[$key]["salary_from"]+((($marks_array[$key]["salary_to"]-$marks_array[$key]["salary_from"])/3)*1), 2) : ($student_percentage < 90 ? number_format($marks_array[$key]["salary_from"]+((($marks_array[$key]["salary_to"]-$marks_array[$key]["salary_from"])/3)*2), 2) : number_format($marks_array[$key]["salary_from"]+((($marks_array[$key]["salary_to"]-$marks_array[$key]["salary_from"])/3)*3), 2)))) : number_format((($student_percentage-50)/100)+$marks_array[$key]["salary_from"], 2)))).'</td>
<td>'.$marks_array[$key]["student_manager"].'</td>
<td>'.$marks_array[$key]["student_remark"].'</td>
</tr></tbody>';
$table_header .= '
<th>Total</th>
<th>%Percentage</th>
<th>Result</th>
<th>DOP in Veda</th>
<th>Pass/Fail/Supp Veda</th>
<th>DOP in Company</th>
<th>Pass/Fail/Supp Company</th>
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
</tr></thead>';
$subject_marks .= '
<th>'.number_format($subject_total, 2).'</th>
<th>'.number_format(100, 2).'</th>
<th></th>
<th>'.$marks_array[0]["dop_veda"].'</th>
<th></th>
<th>'.$marks_array[0]["dop_company"].'</th>
<th colspan="28"></th>
</tr>';
$result_date .= '<th colspan="34"></th></tr>';
$exam_date .= '<th colspan="34"></th></tr>';
$table_top = '<thead>' . $exam_date . $result_date . $subject_marks . '</thead>';
$table_footer = '<tfoot><tr><td colspan="4">Average Marks</td>';
$tmp = 1;
foreach ($subject_array as $key => $subject) {
if($tmp%3 != 0) {
$table_footer .= '<td>'.number_format(eval('return '.join('+', $subject).';')/$count, 2).'</td>';
} else {
$table_footer .= '<td>'.number_format(eval('return '.join('+', $subject).';')/$count, 2).'</td><td></td><td></td>';	
}
$tmp++;
}
$table_footer .= '
<td>'.number_format($total_total/$count, 2).'</td>
<td>'.round($percentage_total/$count).'</td>
<td colspan="32"></td>
</tr></tfoot>';
$response['details'] .= $table_top;
$response['details'] .= $table_header;
$response['details'] .= $table_data;
$response['details'] .= $table_footer;
$response['details'] .= '
</table>
</div>
</div>
</div>
</div>
</div>';
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

$marks_array = $vedaFaculty->getMarksByDomainSno($_POST['domain_sno']);
if (! empty($marks_array)) {
$response['details'] = ' 
<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-body">
<div class="card-content table-responsive text-nowrap">
<table class="table table-striped table-bordered" id="marks-table">';
$table_top = '
<thead>
<tr>
<th colspan="5">Date</th>
<th>'.$marks_array[0]["dop_veda"].'</th>
<th></th>
<th>'.$marks_array[0]["dop_company"].'</th>
<th colspan="28"></th>
</tr>
</thead>';
$table_header = '
<thead>
<tr>
<th>S.No.</th>
<th>Student Id</th>
<th>First Name</th>
<th>Last Name</th>';
$table_data = '<tbody><tr>';
$current_student = "";
$count = 0;
$subject_total = 0;
$student_total = 0;
$total_total = 0;
$student_percentage = 0;
$percentage_total = 0;
$subject_array = array();
foreach ($marks_array as $key => $value) { 
if($marks_array[$key]["user_id"] == $marks_array[0]["user_id"]){
$subject_total += $marks_array[$key]["subject_marks"];
}
if($marks_array[$key]["user_id"] != $current_student){	
if($count != 0) {
$total_veda_leave = round(((($marks_array[$key-1]["total_late"]/6)+$marks_array[$key-1]["veda_leave"]-$marks_array[$key-1]["od"]-$marks_array[$key-1]["casual_leave"])*2)-min($marks_array[$key-1]["health_leave"], 6) < 0 ? 0 : ((($marks_array[$key-1]["total_late"]/6)+$marks_array[$key-1]["veda_leave"]-$marks_array[$key-1]["od"]-$marks_array[$key-1]["casual_leave"])*2)-min($marks_array[$key-1]["health_leave"], 6));
$veda_working_days = empty($marks_array[$key-1]["student_dop_veda"]) ? 'Awaited' : $vedaFaculty->getWorkingDays($marks_array[$key-1]["dop_veda"], $marks_array[$key-1]["student_dop_veda"]);
$company_doc = empty($marks_array[$key-1]["student_dop_veda"]) ? 'Awaited' : (stripos($marks_array[$key-1]["company_name"], "VEDA") === false ? $vedaFaculty->getNextWorkingDate1($marks_array[$key-1]["dop_company"], $total_veda_leave+$veda_working_days+1) : $vedaFaculty->getNextWorkingDate2($marks_array[$key-1]["dop_company"], $total_veda_leave+$veda_working_days+1));
$credit_leave = (($marks_array[$key-1]["total_late"]/6)+$marks_array[$key-1]["veda_leave"]-$marks_array[$key-1]["od"]-$marks_array[$key-1]["casual_leave"]) >= 0 ? 0 : (($marks_array[$key-1]["total_late"]/6)+$marks_array[$key-1]["veda_leave"]-$marks_array[$key-1]["od"]-$marks_array[$key-1]["casual_leave"]);
$total_company_leave = round($credit_leave+$marks_array[$key-1]["extended_day"]+$marks_array[$key-1]["company_leave"]) <= 0 ? 0 : round($credit_leave+$marks_array[$key-1]["extended_day"]+$marks_array[$key-1]["company_leave"]);
$company_working_days = empty($marks_array[$key-1]["student_dop_company"]) ? 'Awaited' : $vedaFaculty->getWorkingDays($marks_array[$key-1]["dop_company"], $marks_array[$key-1]["student_dop_company"]);
$company_doj = empty($marks_array[$key-1]["student_dop_company"]) ? 'Awaited' : (stripos($marks_array[$key-1]["company_name"], "VEDA") === false ? $vedaFaculty->getNextWorkingDate1($company_doc, $total_company_leave+$company_working_days) : $vedaFaculty->getNextWorkingDate2($company_doc, $total_company_leave+$company_working_days));
$student_percentage = round(($student_total/$subject_total)*100);
$table_data .= '
<td>'.$marks_array[$key-1]["student_dop_veda"].'</td>
<td>'.(empty($marks_array[$key-1]["student_dop_veda"]) ? 'Awaited' : ($student_percentage < 50 ? 'Fail' : (strtotime($marks_array[$key-1]["student_dop_veda"]) > strtotime($marks_array[$key-1]["dop_veda"]) ? 'Supp' : 'Pass'))).'</td>
<td>'.$marks_array[$key-1]["student_dop_company"].'</td>
<td>'.(empty($marks_array[$key-1]["student_dop_company"]) ? 'Awaited' : (strtotime($marks_array[$key-1]["student_dop_company"]) > strtotime($marks_array[$key-1]["dop_company"]) ? 'Supp' : 'Pass')).'</td>
<td>'.$marks_array[$key-1]["student_qualification"].'</td>
<td>'.$marks_array[$key-1]["student_yop"].'</td>
<td>'.$marks_array[$key-1]["company_name"].'</td>
<td>'.$marks_array[$key-1]["training_place"].'</td>
<td>'.$marks_array[$key-1]["work_place"].'</td>
<td>'.$marks_array[$key-1]["training_period"].'</td>
<td>'.$marks_array[$key-1]["bond_amount"].'</td>
<td>'.$marks_array[$key-1]["salary_from"].'</td>
<td>'.$marks_array[$key-1]["salary_to"].'</td>
<td>'.$marks_array[$key-1]["health_leave"].'</td>
<td>'.$marks_array[$key-1]["total_late"].'</td>
<td>'.round($marks_array[$key-1]["total_late"]/6, 1).'</td>
<td>'.$marks_array[$key-1]["veda_leave"].'</td>
<td>'.$marks_array[$key-1]["od"].'</td>
<td>'.$marks_array[$key-1]["casual_leave"].'</td>
<td>'.$total_veda_leave.'</td>
<td>'.$veda_working_days.'</td>
<td>'.$company_doc.'</td>
<td>'.round($credit_leave, 1).'</td>
<td>'.$marks_array[$key-1]["extended_day"].'</td>
<td>'.$marks_array[$key-1]["company_leave"].'</td>
<td>'.$total_company_leave.'</td>
<td>'.$company_working_days.'</td>
<td>'.$company_doj.'</td>
<td>'.(empty($marks_array[$key-1]["student_dop_company"]) || empty($marks_array[$key-1]["salary_from"]) || empty($marks_array[$key-1]["salary_to"]) ? 'Awaited' : (strtotime($marks_array[$key-1]["student_dop_company"]) > strtotime($marks_array[$key-1]["dop_company"]) ? number_format($marks_array[$key-1]["salary_from"], 2) : (stripos($marks_array[$key-1]["domain_id"], "AD") === false ? ($student_percentage < 65 ? number_format($marks_array[$key-1]["salary_from"], 2) : ($student_percentage < 80 ? number_format($marks_array[$key-1]["salary_from"]+((($marks_array[$key-1]["salary_to"]-$marks_array[$key-1]["salary_from"])/3)*1), 2) : ($student_percentage < 90 ? number_format($marks_array[$key-1]["salary_from"]+((($marks_array[$key-1]["salary_to"]-$marks_array[$key-1]["salary_from"])/3)*2), 2) : number_format($marks_array[$key-1]["salary_from"]+((($marks_array[$key-1]["salary_to"]-$marks_array[$key-1]["salary_from"])/3)*3), 2)))) : number_format((($student_percentage-50)/100)+$marks_array[$key-1]["salary_from"], 2)))).'</td>
<td>'.$marks_array[$key-1]["student_manager"].'</td>
<td>'.$marks_array[$key-1]["student_remark"].'</td>
</tr><tr>
<td>'.++$count.'</td><td>'.$marks_array[$key]["user_id"].'</td>
<td>'.$marks_array[$key]["first_name"].'</td>
<td>'.$marks_array[$key]["last_name"].'</td>';	
} else {
$table_data .= '
</tr><tr>
<td>'.++$count.'</td><td>'.$marks_array[$key]["user_id"].'</td>
<td>'.$marks_array[$key]["first_name"].'</td>
<td>'.$marks_array[$key]["last_name"].'</td>';
}
$current_student = $marks_array[$key]["user_id"];
$total_total += $student_total;
$percentage_total += ($student_total/$subject_total)*100;
$student_total = 0;
$student_percentage = 0;
}
$student_total += $marks_array[$key]["max_marks"];
}
$total_total += $student_total;
$percentage_total += ($student_total/$subject_total)*100;
$total_veda_leave = round(((($marks_array[$key]["total_late"]/6)+$marks_array[$key]["veda_leave"]-$marks_array[$key]["od"]-$marks_array[$key]["casual_leave"])*2)-min($marks_array[$key]["health_leave"], 6) < 0 ? 0 : ((($marks_array[$key]["total_late"]/6)+$marks_array[$key]["veda_leave"]-$marks_array[$key]["od"]-$marks_array[$key]["casual_leave"])*2)-min($marks_array[$key]["health_leave"], 6));
$veda_working_days = empty($marks_array[$key]["student_dop_veda"]) ? 'Awaited' : $vedaFaculty->getWorkingDays($marks_array[$key]["dop_veda"], $marks_array[$key]["student_dop_veda"]);
$company_doc = empty($marks_array[$key]["student_dop_veda"]) ? 'Awaited' : (stripos($marks_array[$key]["company_name"], "VEDA") === false ? $vedaFaculty->getNextWorkingDate1($marks_array[$key]["dop_company"], $total_veda_leave+$veda_working_days+1) : $vedaFaculty->getNextWorkingDate2($marks_array[$key]["dop_company"], $total_veda_leave+$veda_working_days+1));
$credit_leave = (($marks_array[$key]["total_late"]/6)+$marks_array[$key]["veda_leave"]-$marks_array[$key]["od"]-$marks_array[$key]["casual_leave"]) >= 0 ? 0 : (($marks_array[$key]["total_late"]/6)+$marks_array[$key]["veda_leave"]-$marks_array[$key]["od"]-$marks_array[$key]["casual_leave"]);
$total_company_leave = round($credit_leave+$marks_array[$key]["extended_day"]+$marks_array[$key]["company_leave"]) <= 0 ? 0 : round($credit_leave+$marks_array[$key]["extended_day"]+$marks_array[$key]["company_leave"]);
$company_working_days = empty($marks_array[$key]["student_dop_company"]) ? 'Awaited' : $vedaFaculty->getWorkingDays($marks_array[$key]["dop_company"], $marks_array[$key]["student_dop_company"]);
$company_doj = empty($marks_array[$key]["student_dop_company"]) ? 'Awaited' : (stripos($marks_array[$key]["company_name"], "VEDA") === false ? $vedaFaculty->getNextWorkingDate1($company_doc, $total_company_leave+$company_working_days) : $vedaFaculty->getNextWorkingDate2($company_doc, $total_company_leave+$company_working_days));
$student_percentage = round(($student_total/$subject_total)*100);
$table_data .= '
<td>'.$marks_array[$key]["student_dop_veda"].'</td>
<td>'.(empty($marks_array[$key]["student_dop_veda"]) ? 'Awaited' : ($student_percentage < 50 ? 'Fail' : (strtotime($marks_array[$key]["student_dop_veda"]) > strtotime($marks_array[$key]["dop_veda"]) ? 'Supp' : 'Pass'))).'</td>
<td>'.$marks_array[$key]["student_dop_company"].'</td>
<td>'.(empty($marks_array[$key]["student_dop_company"]) ? 'Awaited' : (strtotime($marks_array[$key]["student_dop_company"]) > strtotime($marks_array[$key]["dop_company"]) ? 'Supp' : 'Pass')).'</td>
<td>'.$marks_array[$key]["student_qualification"].'</td>
<td>'.$marks_array[$key]["student_yop"].'</td>
<td>'.$marks_array[$key]["company_name"].'</td>
<td>'.$marks_array[$key]["training_place"].'</td>
<td>'.$marks_array[$key]["work_place"].'</td>
<td>'.$marks_array[$key]["training_period"].'</td>
<td>'.$marks_array[$key]["bond_amount"].'</td>
<td>'.$marks_array[$key]["salary_from"].'</td>
<td>'.$marks_array[$key]["salary_to"].'</td>
<td>'.$marks_array[$key]["health_leave"].'</td>
<td>'.$marks_array[$key]["total_late"].'</td>
<td>'.round($marks_array[$key]["total_late"]/6, 1).'</td>
<td>'.$marks_array[$key]["veda_leave"].'</td>
<td>'.$marks_array[$key]["od"].'</td>
<td>'.$marks_array[$key]["casual_leave"].'</td>
<td>'.$total_veda_leave.'</td>
<td>'.$veda_working_days.'</td>
<td>'.$company_doc.'</td>
<td>'.round($credit_leave, 1).'</td>
<td>'.$marks_array[$key]["extended_day"].'</td>
<td>'.$marks_array[$key]["company_leave"].'</td>
<td>'.$total_company_leave.'</td>
<td>'.$company_working_days.'</td>
<td>'.$company_doj.'</td>
<td>'.(empty($marks_array[$key]["student_dop_company"]) || empty($marks_array[$key]["salary_from"]) || empty($marks_array[$key]["salary_to"]) ? 'Awaited' : (strtotime($marks_array[$key]["student_dop_company"]) > strtotime($marks_array[$key]["dop_company"]) ? number_format($marks_array[$key]["salary_from"], 2) : (stripos($marks_array[$key]["domain_id"], "AD") === false ? ($student_percentage < 65 ? number_format($marks_array[$key]["salary_from"], 2) : ($student_percentage < 80 ? number_format($marks_array[$key]["salary_from"]+((($marks_array[$key]["salary_to"]-$marks_array[$key]["salary_from"])/3)*1), 2) : ($student_percentage < 90 ? number_format($marks_array[$key]["salary_from"]+((($marks_array[$key]["salary_to"]-$marks_array[$key]["salary_from"])/3)*2), 2) : number_format($marks_array[$key]["salary_from"]+((($marks_array[$key]["salary_to"]-$marks_array[$key]["salary_from"])/3)*3), 2)))) : number_format((($student_percentage-50)/100)+$marks_array[$key]["salary_from"], 2)))).'</td>
<td>'.$marks_array[$key]["student_manager"].'</td>
<td>'.$marks_array[$key]["student_remark"].'</td>
</tr></tbody>';
$table_header .= '
<th>DOP in Veda</th>
<th>Pass/Fail/Supp Veda</th>
<th>DOP in Company</th>
<th>Pass/Fail/Supp Company</th>
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
</tr></thead>';
$response['details'] .= $table_top;
$response['details'] .= $table_header;
$response['details'] .= $table_data;
$response['details'] .= '
</table>
</div>
</div>
</div>
</div>
</div>
<script>
$("#marks-table").tableExport({
headers: true,                   
footers: true,
formats: ["xls"],     
filename: "Result_'.$marks_array[0]["domain_id"].'",                                                             
bootstrap: true,
exportButtons: true,                         
position: "bottom",                  
ignoreRows: [0],                            
ignoreCols: null,                  
trimWhitespace: true
});
</script>
';
$response['status'] = 'success';
}
else
{
$response['status'] = 'error'; 
$response['message'] = 'Not found any result of student';	
}	


}

} else {
$response['status'] = 'error'; 
$response['message'] = 'Missing parameters, Try again...';	
}

echo json_encode($response);
?>
