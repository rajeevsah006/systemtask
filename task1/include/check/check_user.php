<?php
require_once "../class/SystemTask.php";
$systemTask = new SystemTask();
$check_user = $systemTask->isUserEmailAvailable($_POST['user_email']);
if (!empty($check_user))
{
	echo 'false';
}
else
{
	echo 'true';
}
