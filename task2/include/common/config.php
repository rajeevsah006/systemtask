<?php
session_start();
$script_name = pathinfo($_SERVER['SCRIPT_NAME'])['filename'];
if (isset($_SESSION['session_employee_sno']))
{
	$redirect = false;
	echo "<style>.super-admin-item, .admin-item, .user-item { display: none; }</style>";
	switch ($_SESSION['session_employee_role'])
	{
		case "Admin":
			if (!in_array($script_name, array("dashboard", "users", "update_user"))) $redirect = true;
			echo "<style>.admin-item { display: block; }</style>";
			break;
		case "User":
			if (!in_array($script_name, array("dashboard", "update_user"))) $redirect = true;
			echo "<style>.user-item { display: block; }</style>";
			break;
		default:
			$redirect = false;
			echo "<style>.super-admin-item { display: block; }</style>";
	}
	if ($redirect || $script_name == "index")
	{
		header('Location: dashboard');
		exit();
	}
}
else
{
	if (!in_array($script_name, array("index", "register")))
	{
		header('Location: index');
		exit();
	}
}
require_once "include/class/SystemTask.php";
$systemTask = new SystemTask();
