<?php
require_once "DBController.php";

class SystemTask extends DBController
{
	/*------------------------------- user start ------------------------------------------*/

	function isAdminPermissionAvailable($user_sno)
	{
		$query = "SELECT 1 FROM `user_tb` WHERE `user_sno` = ? AND `user_type` = 'Admin'";

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

	function isStaffPermissionAvailable($user_sno)
	{
		$query = "SELECT 1 FROM `user_tb` WHERE `user_sno` = ? AND (`user_type` = 'Faculty' OR `user_type` = 'Admin')";

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

	function isHrPermissionAvailable($user_sno)
	{
		$query = "SELECT 1 FROM `user_tb` WHERE `user_sno` = ? AND (`user_type` = 'HR Veda' OR `user_type` = 'HR Comapny' OR `user_type` = 'Admin')";

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

	function isAdminAvailable()
	{
		$query = "SELECT COUNT(`user_sno`) AS `admin_count` FROM `user_tb` WHERE `user_type` = 'Admin' AND `user_visible` = 'YES' HAVING `admin_count` > 1";

		$userResult = $this->getDBResult($query);
		return $userResult;
	}

	function isUserNameAvailable($user_name)
	{
		$query = "SELECT 1 FROM `user_tb` WHERE `user_visible` = 'YES' AND `user_name` = ?";

		$user_name = strtolower(strip_tags(trim($user_name)));

		$params = array(
			array(
				"param_type" => "s",
				"param_value" => $user_name
			)
		);

		$userResult = $this->getDBResult($query, $params);
		return $userResult;
	}

	function isUserIdAvailable($user_id)
	{
		$query = "SELECT 1 FROM `user_tb` WHERE `user_visible` = 'YES' AND `user_id` = ?";

		$user_id = strtoupper(strip_tags(trim($user_id)));

		$params = array(
			array(
				"param_type" => "s",
				"param_value" => $user_id
			)
		);

		$userResult = $this->getDBResult($query, $params);
		return $userResult;
	}

	function getAllStaff()
	{
		$query = "SELECT * FROM `user_vw` WHERE `domain_id` = 'STAFF' AND `user_visible` = 'YES' ORDER BY `first_name` ASC";

		$userResult = $this->getDBResult($query);
		return $userResult;
	}

	function getAllFaculty()
	{
		$query = "SELECT * FROM `user_vw` WHERE `domain_id` = 'STAFF' AND (`user_type` = 'Faculty' OR `user_type` = 'Admin') AND `user_visible` = 'YES' ORDER BY `first_name` ASC";

		$userResult = $this->getDBResult($query);
		return $userResult;
	}

	function getAllStudent()
	{
		$query = "SELECT * FROM `user_vw` WHERE `domain_running` = 'YES' AND `user_type` = 'Student' AND `user_visible` = 'YES' ORDER BY `user_id` ASC";

		$userResult = $this->getDBResult($query);
		return $userResult;
	}

	function getAllUserByUserSno($user_sno)
	{
		$query = "SELECT * FROM `user_vw` WHERE `domain_id` = (select `domain_id` FROM `user_vw` WHERE `user_sno` = ?) AND `user_visible` = 'YES' ORDER BY `user_id` ASC";

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

	function getUserByUserSno($user_sno)
	{
		$query = "SELECT * FROM `user_vw` WHERE `user_sno` = ?";

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

	function getUserSnoByFullName($full_name)
	{
		$query = "SELECT * FROM `user_tb` WHERE `user_visible` = 'YES' AND CONCAT(`first_name`, ' ',`last_name`) LIKE ?";

		$params = array(
			array(
				"param_type" => "s",
				"param_value" => $full_name
			)
		);

		$userResult = $this->getDBResult($query, $params);
		return $userResult;
	}

	function validateUserName($user_name)
	{
		$query = "SELECT `user_sno`, `user_password`, `user_type`, `mobile_no` FROM `user_tb` WHERE `user_visible` = 'YES' AND `user_name` = ?";

		$params = array(
			array(
				"param_type" => "s",
				"param_value" => $user_name
			)
		);

		$userResult = $this->getDBResult($query, $params);
		return $userResult;
	}

	function getUserByDomainSno($domain_sno)
	{
		$query = "SELECT * FROM `user_vw` WHERE `user_visible` = 'YES' AND FIND_IN_SET(`domain_sno`, ?) ORDER BY `user_id` ASC";

		$domain_sno = strip_tags(trim($domain_sno));

		$params = array(
			array(
				"param_type" => "s",
				"param_value" => $domain_sno
			)
		);

		$userResult = $this->getDBResult($query, $params);
		return $userResult;
	}

	function insertUser($value_arr)
	{
		$query = "INSERT INTO `user_tb`(`user_id`, `first_name`, `last_name`, `user_name`, `user_password`, `domain_sno`, `user_type`, `user_qualification`, `user_yop`, `mobile_no`, `email_id`, `company_name`, `training_period`, `bond_amount`, `salary_from`, `salary_to`, `user_image`, `user_visible`, `user_date`) VALUES $value_arr ON DUPLICATE KEY UPDATE first_name = VALUES(first_name), last_name = VALUES(last_name), user_name = VALUES(user_name), user_password = VALUES(user_password), domain_sno = VALUES(domain_sno), user_type = VALUES(user_type), user_qualification = VALUES(user_qualification), user_yop = VALUES(user_yop), mobile_no = VALUES(mobile_no), email_id = VALUES(email_id), company_name = VALUES(company_name), training_period = VALUES(training_period), bond_amount = VALUES(bond_amount), salary_from = VALUES(salary_from), salary_to = VALUES(salary_to), user_image = VALUES(user_image), user_visible = VALUES(user_visible), user_date = VALUES(user_date)";

		$user_sno = $this->insertDB($query);
		return $user_sno;
	}

	function updateUser($user_detail)
	{
		$query = "UPDATE `user_tb` SET `first_name` = IFNULL(?, `first_name`), `last_name` = IFNULL(?, `last_name`), `user_name` = IFNULL(?, `user_name`), `user_password` = IFNULL(?, `user_password`), `user_type` = IFNULL(?, `user_type`), `user_qualification` = IFNULL(?, `user_qualification`), `user_yop` = IFNULL(?, `user_yop`), `mobile_no` = IFNULL(?, `mobile_no`), `email_id` = IFNULL(?, `email_id`), `company_name` = IFNULL(?, `company_name`), `training_place` = IFNULL(?, `training_place`), `work_place` = IFNULL(?, `work_place`), `training_period` = IFNULL(?, `training_period`), `bond_amount` = IFNULL(?, `bond_amount`), `salary_from` = IFNULL(?, `salary_from`), `salary_to` = IFNULL(?, `salary_to`), `user_dop_veda` = IFNULL(?, `user_dop_veda`), `user_dop_company` = IFNULL(?, `user_dop_company`), `user_manager` = IFNULL(?, `user_manager`), `health_leave` = IFNULL(?, `health_leave`), `total_late` = IFNULL(?, `total_late`), `veda_leave` = IFNULL(?, `veda_leave`), `od_leave` = IFNULL(?, `od_leave`), `company_leave` = IFNULL(?, `company_leave`), `extended_days` = IFNULL(?, `extended_days`), `user_date` = IFNULL(?, `user_date`), `user_remark` = IFNULL(?, `user_remark`) WHERE FIND_IN_SET(`user_sno`, ?)";

		$user_sno = strip_tags(trim($user_detail['user_sno']));
		$first_name = $user_detail['first_name'] != 'Unchanged' ? ucwords(strtolower(strip_tags(trim($user_detail['first_name'])))) : NULL;
		$last_name = $user_detail['last_name'] != 'Unchanged' ? ucwords(strtolower(strip_tags(trim($user_detail['last_name'])))) : NULL;
		$user_name = $user_detail['user_name'] != 'Unchanged' ? strtolower(strip_tags(trim($user_detail['user_name']))) : NULL;
		$user_password = $user_detail['user_password'] != 'Unchanged' ? hash('sha256', strip_tags(trim($user_detail['user_password']))) : NULL;
		$user_type = $user_detail['user_type'] != 'Unchanged' ? strip_tags(trim($user_detail['user_type'])) : NULL;
		$user_qualification = $user_detail['user_qualification'] != 'Unchanged' ? strip_tags(trim($user_detail['user_qualification'])) : NULL;
		$user_yop = $user_detail['user_yop'] != 'Unchanged' ? strip_tags(trim($user_detail['user_yop'])) : NULL;
		$mobile_no = $user_detail['mobile_no'] != 'Unchanged' ? strip_tags(trim($user_detail['mobile_no'])) : NULL;
		$email_id = $user_detail['email_id'] != 'Unchanged' ? strtolower(strip_tags(trim($user_detail['email_id']))) : NULL;
		$company_name = $user_detail['company_name'] != 'Unchanged' ? strip_tags(trim($user_detail['company_name'])) : NULL;
		$training_place = $user_detail['training_place'] != 'Unchanged' ? strip_tags(trim($user_detail['training_place'])) : NULL;
		$work_place = $user_detail['work_place'] != 'Unchanged' ? strip_tags(trim($user_detail['work_place'])) : NULL;
		$training_period = $user_detail['training_period'] != 'Unchanged' ? strip_tags(trim($user_detail['training_period'])) : NULL;
		$bond_amount = $user_detail['bond_amount'] != 'Unchanged' ? strip_tags(trim($user_detail['bond_amount'])) : NULL;
		$salary_from = $user_detail['salary_from'] != 'Unchanged' ? strip_tags(trim($user_detail['salary_from'])) : NULL;
		$salary_to = $user_detail['salary_to'] != 'Unchanged' ? strip_tags(trim($user_detail['salary_to'])) : NULL;
		$user_dop_veda = $user_detail['user_dop_veda'] != 'Unchanged' ? strip_tags(trim($user_detail['user_dop_veda'])) : NULL;
		$user_dop_company = $user_detail['user_dop_company'] != 'Unchanged' ? strip_tags(trim($user_detail['user_dop_company'])) : NULL;
		$user_manager = $user_detail['user_manager'] != 'Unchanged' ? ucwords(strtolower(strip_tags(trim($user_detail['user_manager'])))) : NULL;
		$health_leave = $user_detail['health_leave'] != 'Unchanged' ? strip_tags(trim($user_detail['health_leave'])) : NULL;
		$total_late = $user_detail['total_late'] != 'Unchanged' ? strip_tags(trim($user_detail['total_late'])) : NULL;
		$veda_leave = $user_detail['veda_leave'] != 'Unchanged' ? strip_tags(trim($user_detail['veda_leave'])) : NULL;
		$od_leave = $user_detail['od_leave'] != 'Unchanged' ? strip_tags(trim($user_detail['od_leave'])) : NULL;
		$company_leave = $user_detail['company_leave'] != 'Unchanged' ? strip_tags(trim($user_detail['company_leave'])) : NULL;
		$extended_days = $user_detail['extended_days'] != 'Unchanged' ? strip_tags(trim($user_detail['extended_days'])) : NULL;
		$user_date = $user_detail['user_date'] != 'Unchanged' ? strip_tags(trim($user_detail['user_date'])) : NULL;
		$user_remark = $user_detail['user_remark'] != 'Unchanged' ? strip_tags(trim($user_detail['user_remark'])) : NULL;

		$params = array(
			array(
				"param_type" => "s",
				"param_value" => $first_name
			),
			array(
				"param_type" => "s",
				"param_value" => $last_name
			),
			array(
				"param_type" => "s",
				"param_value" => $user_name
			),
			array(
				"param_type" => "s",
				"param_value" => $user_password
			),
			array(
				"param_type" => "s",
				"param_value" => $user_type
			),
			array(
				"param_type" => "s",
				"param_value" => $user_qualification
			),
			array(
				"param_type" => "s",
				"param_value" => $user_yop
			),
			array(
				"param_type" => "s",
				"param_value" => $mobile_no
			),
			array(
				"param_type" => "s",
				"param_value" => $email_id
			),
			array(
				"param_type" => "s",
				"param_value" => $company_name
			),
			array(
				"param_type" => "s",
				"param_value" => $training_place
			),
			array(
				"param_type" => "s",
				"param_value" => $work_place
			),
			array(
				"param_type" => "s",
				"param_value" => $training_period
			),
			array(
				"param_type" => "s",
				"param_value" => $bond_amount
			),
			array(
				"param_type" => "s",
				"param_value" => $salary_from
			),
			array(
				"param_type" => "s",
				"param_value" => $salary_to
			),
			array(
				"param_type" => "s",
				"param_value" => $user_dop_veda
			),
			array(
				"param_type" => "s",
				"param_value" => $user_dop_company
			),
			array(
				"param_type" => "s",
				"param_value" => $user_manager
			),
			array(
				"param_type" => "d",
				"param_value" => $health_leave
			),
			array(
				"param_type" => "d",
				"param_value" => $total_late
			),
			array(
				"param_type" => "d",
				"param_value" => $veda_leave
			),
			array(
				"param_type" => "d",
				"param_value" => $od_leave
			),
			array(
				"param_type" => "d",
				"param_value" => $company_leave
			),
			array(
				"param_type" => "d",
				"param_value" => $extended_days
			),
			array(
				"param_type" => "s",
				"param_value" => $user_date
			),
			array(
				"param_type" => "s",
				"param_value" => $user_remark
			),
			array(
				"param_type" => "s",
				"param_value" => $user_sno
			)
		);

		$this->updateDB($query, $params);
	}

	function updateLeave($value_arr)
	{
		$query = "INSERT INTO `user_tb`(`user_sno`, `health_leave`, `total_late`, `veda_leave`, `od_leave`, `company_leave`) VALUES $value_arr ON DUPLICATE KEY UPDATE health_leave = VALUES(health_leave), total_late = VALUES(total_late), veda_leave = VALUES(veda_leave), od_leave = VALUES(od_leave), company_leave = VALUES(company_leave)";

		$user_sno = $this->insertDB($query);
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

	function deleteUser($user_sno)
	{
		$query = "UPDATE `user_tb` SET `user_visible` = 'NO' WHERE FIND_IN_SET(`user_sno`, ?)";

		$user_sno = strip_tags(trim($user_sno));

		$params = array(
			array(
				"param_type" => "s",
				"param_value" => $user_sno
			)
		);

		$this->updateDB($query, $params);
	}

	/*------------------------------- user end --------------------------------------------*/
}
