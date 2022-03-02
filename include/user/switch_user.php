<?php
session_start();
$_SESSION['session_user_type'] = ($_SESSION['session_user_type'] == 'Diploma' ? 'MS' : 'Diploma');
if (isset($_COOKIE['remember_me']))
{
	setcookie('session_user_type', $_SESSION['session_user_type'], time() + (30 * 24 * 60 * 60 * 1000), '/');
}
