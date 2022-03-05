<?php
require_once "DBController.php";

class SystemTask extends DBController
{
	/*------------------------------- employee start ------------------------------------------*/

	function isSuperAdminPermissionAvailable($employee_sno)
	{
		$query = "SELECT 1 FROM `employee_tb` WHERE `employee_sno` = ? AND `employee_role` = 'Super Admin'";

		$employee_sno = strip_tags(trim($employee_sno));

		$params = array(
			array(
				"param_type" => "i",
				"param_value" => $employee_sno
			)
		);

		$employeeResult = $this->getDBResult($query, $params);
		return $employeeResult;
	}

	function isAdminPermissionAvailable($employee_sno)
	{
		$query = "SELECT 1 FROM `employee_tb` WHERE `employee_sno` = ? AND (`employee_role` = 'Super Admin' OR `employee_role` = 'Admin')";

		$employee_sno = strip_tags(trim($employee_sno));

		$params = array(
			array(
				"param_type" => "i",
				"param_value" => $employee_sno
			)
		);

		$employeeResult = $this->getDBResult($query, $params);
		return $employeeResult;
	}

	function getAllEmployee($page_number, $limit, $keyword)
	{
		$query = "SELECT * FROM employee_tb et JOIN (SELECT COUNT(employee_sno) as employee_count FROM employee_tb WHERE employee_role = 'User' AND (employee_name LIKE '%$keyword%' OR employee_email LIKE '%$keyword%')) ec WHERE et.employee_role = 'User' AND (et.employee_name LIKE '%$keyword%' OR et.employee_email LIKE '%$keyword%') ORDER BY et.employee_sno ASC LIMIT $page_number, $limit";

		$employeeResult = $this->getDBResult($query);
		return $employeeResult;
	}

	function getEmployeeByEmployeeSno($employee_sno)
	{
		$query = "SELECT * FROM `employee_tb` WHERE `employee_sno` = ?";

		$employee_sno = strip_tags(trim($employee_sno));

		$params = array(
			array(
				"param_type" => "i",
				"param_value" => $employee_sno
			)
		);

		$employeeResult = $this->getDBResult($query, $params);
		return $employeeResult;
	}

	function validateUserName($employee_email)
	{
		$query = "SELECT * FROM `employee_tb` WHERE `employee_email` = ?";

		$params = array(
			array(
				"param_type" => "s",
				"param_value" => $employee_email
			)
		);

		$employeeResult = $this->getDBResult($query, $params);
		return $employeeResult;
	}

	function updateEmployee($employee_detail, $file_detail)
	{
		$query = "UPDATE `employee_tb` SET `employee_name`=?, `employee_mobile`=?, `employee_dob`=?, `employee_bg`=?, `employee_address`=?,`employee_identify`=IFNULL(?, `employee_identify`), `employee_date`=? WHERE `employee_sno`=?";

		$employee_sno = strip_tags(trim($employee_detail['employee_sno']));
		$employee_name = ucwords(strtolower(strip_tags(trim($employee_detail['employee_name']))));
		$employee_mobile = strip_tags(trim($employee_detail['employee_mobile']));
		$employee_dob = strip_tags(trim($employee_detail['employee_dob']));
		$employee_bg = strip_tags(trim($employee_detail['employee_bg']));
		$employee_address = strip_tags(trim($employee_detail['employee_address']));
		if (isset($file_detail['employee_identify']) && !empty($file_detail['employee_identify']['name']))
		{
			$employee_array = $this->getEmployeeByEmployeeSno($employee_sno);
			if (!empty($employee_array[0]['employee_identify']) && file_exists('../../images/identify/' . basename($employee_array[0]["employee_identify"])))
			{
				unlink('../../images/identify/' . basename($employee_array[0]["employee_identify"]));
			}
			$file_ext = pathinfo($file_detail['employee_identify']['name'], PATHINFO_EXTENSION);
			$employee_identify = time() . '.' . $file_ext;
			$tmp_name = $file_detail['employee_identify']['tmp_name'];
			move_uploaded_file($tmp_name, '../../images/identify/' . $employee_identify);
			$employee_identify = 'http://localhost/systemtask/task2/images/identify/' . $employee_identify;
		}
		else
		{
			$employee_identify = NULL;
		}
		$employee_date = date("d-m-Y");

		$params = array(
			array(
				"param_type" => "s",
				"param_value" => $employee_name
			),
			array(
				"param_type" => "s",
				"param_value" => $employee_mobile
			),
			array(
				"param_type" => "s",
				"param_value" => $employee_dob
			),
			array(
				"param_type" => "s",
				"param_value" => $employee_bg
			),
			array(
				"param_type" => "s",
				"param_value" => $employee_address
			),
			array(
				"param_type" => "s",
				"param_value" => $employee_identify
			),
			array(
				"param_type" => "s",
				"param_value" => $employee_date
			),
			array(
				"param_type" => "i",
				"param_value" => $employee_sno
			)
		);

		$this->updateDB($query, $params);
	}

	function updateEmployeePassword($employee_detail, $employee_sno)
	{
		$query = "UPDATE `employee_tb` SET `employee_password`= ? WHERE `employee_sno` = ?";

		$employee_password = strip_tags(trim($employee_detail['new_password']));
		$hashed_password = hash('sha256', $employee_password);
		$employee_sno = strip_tags(trim($employee_sno));

		$params = array(
			array(
				"param_type" => "s",
				"param_value" => $hashed_password
			),
			array(
				"param_type" => "i",
				"param_value" => $employee_sno
			)
		);

		$this->updateDB($query, $params);
	}
	/*------------------------------- employee end --------------------------------------------*/
}
