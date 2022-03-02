<?php
header('Content-type: application/json');
$response = array();
session_start();
require_once "../class/VedaFaculty.php";
$vedaFaculty = new VedaFaculty();
if (isset($_GET["domain_sno"]) && !empty($_GET["domain_sno"]))
{
	$domain_array = $vedaFaculty->getDomainByDomainSno($_GET["domain_sno"]);
	$response['domain_array'] = $domain_array;
	$response['status'] = 'success';
}
else
{
	$response['status'] = 'error';
	$response['message'] = 'Missing parameters, Try again...';
}
echo json_encode($response);
