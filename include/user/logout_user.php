<?php
session_start();
session_unset();
session_destroy();
if (isset($_COOKIE['remember_me']))
{
	setcookie('remember_me', '', time() - (30 * 24 * 60 * 60 * 1000), '/');
	setcookie('veda_user_sno', '', time() - (30 * 24 * 60 * 60 * 1000), '/');
	setcookie('veda_user_type', '', time() - (30 * 24 * 60 * 60 * 1000), '/');
	setcookie('session_user_type', '', time() - (30 * 24 * 60 * 60 * 1000), '/');
}
