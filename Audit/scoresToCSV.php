<?php
require_once("_include/queryManager.php");

$auditID = $_GET['a'];

$data = new queryManager();
$audit = $data->getAudit($auditID);

$auditNaam = $audit[0]["AuditNaam"];

$auditNaam = str_replace(" ", "_", $auditNaam);

$done = $data->createCSV($auditID, $auditNaam);

?>
