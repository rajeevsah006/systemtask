<?php
session_start();
$script_name = pathinfo($_SERVER['SCRIPT_NAME'])['filename'];
if (isset($_SESSION['veda_user_sno']))
{
	$redirect = false;
	echo "<style>.admin-item, .faculty-item, .hr-veda-item, .hr-company-item, .diploma-item, .ms-item { display: none; }</style>";
	switch ($_SESSION['veda_user_type'])
	{
		case "Diploma":
			if (!in_array($script_name, array("dashboard", "result", "holiday"))) $redirect = true;
			echo "<style>.diploma-item { display: block; }</style>";
			break;
		case "MS":
			if (!in_array($script_name, array("dashboard", "result", "holiday"))) $redirect = true;
			echo "<style>.ms-item { display: block; }</style>";
			break;
		case "Faculty":
			if (!in_array($script_name, array("dashboard", "domain", "subject", "student", "exam", "add_exam", "marks", "add_marks", "result", "holiday"))) $redirect = true;
			echo "<style>.faculty-item { display: block; }</style>";
			break;
		case "HR Veda":
			if (!in_array($script_name, array("dashboard", "domain", "add_domain", "student", "add_student", "leave", "result", "holiday", "add_holiday"))) $redirect = true;
			echo "<style>.hr-veda-item { display: block; }</style>";
			break;
		case "HR Company":
			if (!in_array($script_name, array("dashboard", "domain", "add_domain", "student", "add_student", "leave", "result", "holiday", "add_holiday"))) $redirect = true;
			echo "<style>.hr-company-item { display: block; }</style>";
			break;
		default:
			$redirect = false;
			echo "<style>.admin-item { display: block; }</style>";
	}
	if ($redirect || $script_name == "index")
	{
		header('Location: dashboard');
		exit();
	}
}
else
{
	if ($script_name != "index")
	{
		header('Location: index');
		exit();
	}
}
require_once "include/class/SystemTask.php";
$systemTask = new SystemTask();
