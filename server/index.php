<?php
include_once ('../config_db.inc.php');
include_once ('../sec_funcs.php');
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
date_default_timezone_set('America/Los_Angeles');
header("Access-Control-Allow-Origin: *");

$app->get('/reports', function () use ($app) {
	$app->response()->header('Content-Type', 'application/json');
	$app->response()->setStatus(205); //205 response code makes a new page not open
	$date = $_GET['date'];
	$route = ''; // declare route variable
	$conn = getconnection();
	$query = "TRUNCATE TABLE results"; // clear result table for new entries
	$execute = $conn->query($query);
	if (isset($_GET['route']) && $_GET['route'] != '' ) { //if a route is provided, go here
		$rows = array(); //declare variables before loop to prevent deletion of content
		$array1 = array();
		$array2 = array();
		$addrs = array();
		$addrs2 = array();
		foreach ($_GET['route'] as $route) { //loops through each route provided
			$routeQuery = "SELECT InstanceID FROM spot_route WHERE RouteName LIKE '".$route."'";
			$routeResult = $conn->query($routeQuery);
			$rrRow = mysqli_fetch_row($routeResult);
			$routeId = $rrRow[0]; // translates route name to routeId to be used in spot_invoice

			$query = "SELECT DISTINCT(Address1), count(*) FROM spot_invoice WHERE DATE(PromisedDate) = '".$date."' AND Route_ID = '".$routeId."' AND Voided=0 AND Route_ID
			IN (SELECT InstanceID FROM spot_route WHERE Active=1) AND closet_barcode NOT LIKE 'UNKNOWN' GROUP BY Address1";
			$result = $conn->query($query); //get address and promised columns
			$query2 = "SELECT DISTINCT(spot_group), count(*) FROM spot_invoice_driver_audit WHERE
			DATE(created_on) = '".$date."' GROUP BY spot_group;";
			$result2 = $conn->query($query2); //get scanned column
			$i = 1;

			$query = "INSERT INTO results (address, loweredit, col2, date, route) VALUES(?,?,?,?,?)"; //enter a row into results table
			$stmt = $conn->prepare($query);
			$editQuery = "UPDATE results SET col3 =? WHERE loweredit =?"; // add col3 to above row
			$edit = $conn->prepare($editQuery);
			while ($row = mysqli_fetch_row($result)) { // put the appropriate address and promised columns with correct row
				$array1[$i] = $row;
				$addrs[$i] = strtolower($row[0]);
				$stmt->bind_param("sssss", $row[0], $addrs[$i], $row[1], $date, $route);
				$stmt->execute();
				$i++;
			}
			$i = 1;
			while ($row = mysqli_fetch_row($result2)) { // put the appropriate scanned column with correct row
				$key = array_search(strtolower($row[0]), ($addrs));
				if ($key != 0) {
					array_push($array1[$key], $row[1]);
					$lc = strtolower($row[0]);
					$edit->bind_param("ss", $row[1], $lc);
					$edit->execute();
				}
			}
		}
		echo json_encode($array1);
	}
	else { // if a route(s) was not provided, go here
		// this is almost identical to the above part, but with no route specified
		$query = "SELECT DISTINCT(Address1), count(*) FROM spot_invoice WHERE DATE(PromisedDate) = '".$date."' AND Route_ID IS NOT NULL AND Voided=0 AND Route_ID
		IN (SELECT InstanceID FROM spot_route WHERE Active=1) AND closet_barcode NOT LIKE 'UNKNOWN' GROUP BY Address1";
		$result = $conn->query($query);
		$query2 = "SELECT DISTINCT(spot_group), count(*) FROM spot_invoice_driver_audit WHERE
		DATE(created_on) = '".$date."' GROUP BY spot_group;";
		$result2 = $conn->query($query2);
		$rows = array();
		$array1 = array();
		$array2 = array();
		$i = 1;
		$addrs = array();
		$query = "INSERT INTO results (address, loweredit, col2, date) VALUES(?,?,?,?)";
		$stmt = $conn->prepare($query);
		$editQuery = "UPDATE results SET col3 =? WHERE loweredit =?";
		$edit = $conn->prepare($editQuery);
		while ($row = mysqli_fetch_row($result)) {
			$array1[$i] = $row;
			$addrs[$i] = strtolower($row[0]);
			$stmt->bind_param("ssss", $row[0], $addrs[$i], $row[1], $date);
			$stmt->execute();
			$i++;
		}
		$i = 1;
		$addrs2 = array();
		while ($row = mysqli_fetch_row($result2)) {
			$key = array_search(strtolower($row[0]), ($addrs));
			if ($key != 0) {
				array_push($array1[$key], $row[1]);
				$lc = strtolower($row[0]);
				$edit->bind_param("ss", $row[1], $lc);
				$edit->execute();
			}
		}
		echo json_encode($array1);
	}
});

$app->run();

function getconnection(){
    global $db_host, $db_user, $db_pass, $db_name;
    $conn = mysqli_connect($db_host, $db_user, '', $db_name) or die("Error " . mysqli_error($conn));
    $conn->set_charset("latin1");
    return $conn;
}


?>
