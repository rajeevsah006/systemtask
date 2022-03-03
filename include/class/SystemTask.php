<?php
require_once "DBController.php";

class SystemTask extends DBController
{
	/*------------------------------- user start ------------------------------------------*/

	function isSuperAdminPermissionAvailable($user_sno)
	{
		$query = "SELECT 1 FROM `user_tb` WHERE `user_sno` = ? AND `user_role` = 'Super Admin'";

		$user_sno = strip_tags(trim($user_sno));

		$params = array(
			array(
				"param_type" => "i",
				"param_value" => $user_sno
			)
		);

		$userResult = $this->getDBResult($query, $params);
		return $userResult;
	}

	function isAdminPermissionAvailable($user_sno)
	{
		$query = "SELECT 1 FROM `user_tb` WHERE `user_sno` = ? AND (`user_role` = 'Super Admin' OR `user_role` = 'Admin')";

		$user_sno = strip_tags(trim($user_sno));

		$params = array(
			array(
				"param_type" => "i",
				"param_value" => $user_sno
			)
		);

		$userResult = $this->getDBResult($query, $params);
		return $userResult;
	}

	function isUserEmailAvailable($user_email)
	{
		$query = "SELECT 1 FROM `user_tb` WHERE `user_email` = ?";

		$user_email = strtolower(strip_tags(trim($user_email)));

		$params = array(
			array(
				"param_type" => "s",
				"param_value" => $user_email
			)
		);

		$userResult = $this->getDBResult($query, $params);
		return $userResult;
	}

	function getAllUser()
	{
		$query = "SELECT * FROM `user_tb` WHERE `user_role` = 'User' ORDER BY `user_sno` ASC";

		$userResult = $this->getDBResult($query);
		return $userResult;
	}

	function getUserByUserSno($user_sno)
	{
		$query = "SELECT * FROM `user_tb` WHERE `user_sno` = ?";

		$user_sno = strip_tags(trim($user_sno));

		$params = array(
			array(
				"param_type" => "i",
				"param_value" => $user_sno
			)
		);

		$userResult = $this->getDBResult($query, $params);
		return $userResult;
	}

	function validateUserName($user_email)
	{
		$query = "SELECT * FROM `user_tb` WHERE `user_email` = ?";

		$params = array(
			array(
				"param_type" => "s",
				"param_value" => $user_email
			)
		);

		$userResult = $this->getDBResult($query, $params);
		return $userResult;
	}

	function insertUser($user_detail)
	{

		$query = "INSERT INTO `user_tb`(`user_name`, `user_email`, `user_mobile`, `user_password`, `user_date`) VALUES (?, ?, ?, ?, ?)";

		$user_name = ucwords(strtolower(strip_tags(trim($user_detail['user_name']))));
		$user_email = strtolower(strip_tags(trim($user_detail['user_email'])));
		$user_mobile = strip_tags(trim($user_detail['user_mobile']));
		$user_password = strip_tags(trim($user_detail['user_password']));
		$hashed_password = hash('sha256', $user_password);
		$user_date = date("d-m-Y");

		$params = array(
			array(
				"param_type" => "s",
				"param_value" => $user_name
			),
			array(
				"param_type" => "s",
				"param_value" => $user_email
			),
			array(
				"param_type" => "s",
				"param_value" => $user_mobile
			),
			array(
				"param_type" => "s",
				"param_value" => $hashed_password
			),
			array(
				"param_type" => "s",
				"param_value" => $user_date
			)
		);

		$user_sno = $this->insertDB($query, $params);
		return $user_sno;
	}

	function updateUserPassword($user_detail, $user_sno)
	{
		$query = "UPDATE `user_tb` SET `user_password`= ? WHERE `user_sno` = ?";

		$user_password = strip_tags(trim($user_detail['new_password']));
		$hashed_password = hash('sha256', $user_password);
		$user_sno = strip_tags(trim($user_sno));

		$params = array(
			array(
				"param_type" => "s",
				"param_value" => $hashed_password
			),
			array(
				"param_type" => "i",
				"param_value" => $user_sno
			)
		);

		$this->updateDB($query, $params);
	}

	function updateUserVerified($user_verified, $user_sno)
	{
		$query = "UPDATE `user_tb` SET `user_verified` = ? WHERE `user_sno` = ?";

		$user_verified = strip_tags(trim($user_verified));
		$user_sno = strip_tags(trim($user_sno));

		$params = array(
			array(
				"param_type" => "s",
				"param_value" => $user_verified
			),
			array(
				"param_type" => "i",
				"param_value" => $user_sno
			)
		);

		$this->updateDB($query, $params);
	}

	function deleteUser($user_sno)
	{
		$query = "DELETE FROM `user_tb` WHERE `user_sno` = ?";

		$user_sno = strip_tags(trim($user_sno));

		$params = array(
			array(
				"param_type" => "i",
				"param_value" => $user_sno
			)
		);

		$this->updateDB($query, $params);
	}

	/*------------------------------- user end --------------------------------------------*/
}
