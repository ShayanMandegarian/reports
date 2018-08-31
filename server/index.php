<?php
include_once ('../config_db.inc.php');
include_once ('../sec_funcs.php');
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
date_default_timezone_set('America/Los_Angeles');

$app->get('/', function () use ($app) {
	$routes = ['6B2D4159-8006-439A-8C0E-B4039257C076'=>'MT01', '0006E4DB-AE26-44C4-97B3-F3C479C4E53D'=>'MT02',
	'B865C749-A097-4857-AD2F-08A3CF8D32DD'=>'MT03', 'B8A4EB91-D297-4DE5-AB59-A938E6E5F587'=>'TF01', '87CC1001-BA58-454E-B283-8F3A5167A116'=>'TF02',
	'B12EC75A-F770-4C5D-B66F-328DEB495BA2'=>'TF03', '0D39F12E-23AB-4674-88A8-74FD7E951372'=>'Oracle', '24547E17-292B-4711-A272-672F493F5971'=>'Facebook*',
	'372C3EE9-FA6D-4F38-82B2-92B8CFC71BCD'=>'RWC', '42BFB776-9E95-4323-9AC1-EB9857D008D6'=>'MT04', '3AEB62D4-7907-49A4-9775-6B3C5E76B320'=>'TF04',
	'2EB13705-BF1F-4777-9761-6571F4292CB4'=>'MT05', 'F6CB7427-3C4B-47FC-A124-DB4B41F5A219'=>'TF05', 'BE46A7E3-AE16-4CE5-9761-D9B35137483D'=>'Google',
	'FDB0B213-9C2D-48D5-8AB3-DFC414A6494F'=>'Facebook', '853B75EB-9503-49BB-8902-130AA18593BD'=>'Palantir', 'E4C0396F-49B1-4B57-85AB-AA026734FB1F'=>'TF06',
	'D33C7975-8120-4845-B75E-8C1D8AC79587'=>'TF07', 'CA9F8878-737F-4FFE-930B-A3F339B73DF2'=>'Apple', '044FE3E5-4691-446C-872E-8651AC3813E5'=>'Genentech',
	'B773DDB9-FCD3-45C6-B074-356CA8472596'=>'MT06', 'C973E25E-5DD2-4F09-8DB8-3533FF7A2486'=>'MT08', 'DAFF770E-D1DF-444B-904C-2F28D83ACD4E'=>'TF08',
	'C48CC33B-8BE1-4AE2-8DE0-5C4722D3566B'=>'Intel', '762563F6-B28F-4AB2-9616-3AFBB2D85179'=>'MT09', '7048469F-96C9-4424-BEF4-659FD0A4A863'=>'TF09',
	'A18888AC-35C5-4C5B-A28A-53D35E0446B8'=>'MTtemp', 'AAAAAAAA-AAAA-AAAA-AAAA-AAAAAAAAAAAA'=>'StorageDonations'];
	$routesRev = ['MT01'=>'6B2D4159-8006-439A-8C0E-B4039257C076', 'MT02'=>'0006E4DB-AE26-44C4-97B3-F3C479C4E53D',
	'MT03'=>'B865C749-A097-4857-AD2F-08A3CF8D32DD', 'TF01'=>'B8A4EB91-D297-4DE5-AB59-A938E6E5F587', 'TF02'=>'87CC1001-BA58-454E-B283-8F3A5167A116',
	'TF03'=>'B12EC75A-F770-4C5D-B66F-328DEB495BA2', 'Oracle'=>'0D39F12E-23AB-4674-88A8-74FD7E951372', 'Facebook*'=>'24547E17-292B-4711-A272-672F493F5971',
	'RWC'=>'372C3EE9-FA6D-4F38-82B2-92B8CFC71BCD', 'MT04'=>'42BFB776-9E95-4323-9AC1-EB9857D008D6', 'TF04'=>'3AEB62D4-7907-49A4-9775-6B3C5E76B320',
	'MT05'=>'2EB13705-BF1F-4777-9761-6571F4292CB4', 'TF05'=>'F6CB7427-3C4B-47FC-A124-DB4B41F5A219', 'Google'=>'BE46A7E3-AE16-4CE5-9761-D9B35137483D',
	'Facebook'=>'FDB0B213-9C2D-48D5-8AB3-DFC414A6494F', 'Palantir'=>'853B75EB-9503-49BB-8902-130AA18593BD', 'TF06'=>'E4C0396F-49B1-4B57-85AB-AA026734FB1F',
	'TF07'=>'D33C7975-8120-4845-B75E-8C1D8AC79587', 'Apple'=>'CA9F8878-737F-4FFE-930B-A3F339B73DF2', 'Genentech'=>'044FE3E5-4691-446C-872E-8651AC3813E5',
	'MT06'=>'B773DDB9-FCD3-45C6-B074-356CA8472596', 'MT08'=>'C973E25E-5DD2-4F09-8DB8-3533FF7A2486', 'TF08'=>'DAFF770E-D1DF-444B-904C-2F28D83ACD4E',
	'Intel'=>'C48CC33B-8BE1-4AE2-8DE0-5C4722D3566B', 'MT09'=>'762563F6-B28F-4AB2-9616-3AFBB2D85179', 'TF09'=>'7048469F-96C9-4424-BEF4-659FD0A4A863',
	'MTtemp'=>'A18888AC-35C5-4C5B-A28A-53D35E0446B8', 'StorageDonations'=>'AAAAAAAA-AAAA-AAAA-AAAA-AAAAAAAAAAAA'];
	$app->response()->header('Content-Type', 'application/json');
	$app->response()->setStatus(204); //205 response code makes a new page not open
	$date = $_GET['date'];
	$route = ''; // declare route variable
	$conn = getconnection();
	$query = "TRUNCATE TABLE results"; // clear result table for new entries
	$execute = $conn->query($query);
	$array = array();
	$total = array();
	if (isset($_GET['route']) && $_GET['route'] != '' ) { //if a route is provided, go here
		//declare variables before loop to prevent deletion of content
		// $addrs = array();
		foreach ($_GET['route'] as $route) { //loops through each route provided
			$routeId = $routesRev[$route]; // translates route name to routeId to be used in spot_invoice

			$query = "SELECT DISTINCT(Address1), count(*), Route_ID FROM spot_invoice WHERE DATE(PromisedDate) = '".$date."' AND Route_ID = '".$routeId."' AND Voided=0 AND Route_ID
			IN (SELECT InstanceID FROM spot_route WHERE Active=1) AND closet_barcode NOT LIKE 'UNKNOWN' GROUP BY Address1";
			$result = $conn->query($query); //get address and promised columns
			$query2 = "SELECT DISTINCT(spot_group), count(*) FROM spot_invoice_driver_audit WHERE
			DATE(created_on) = '".$date."' GROUP BY spot_group;";
			$result2 = $conn->query($query2); //get scanned column
			$i = 1;

			// $query = "INSERT INTO results (address, loweredit, col2, date, route) VALUES(?,?,?,?,?)"; //enter a row into results table
			// $stmt = $conn->prepare($query);
			// $editQuery = "UPDATE results SET col3 =? WHERE loweredit =?"; // add col3 to above row
			// $edit = $conn->prepare($editQuery);
			$valid = 0;
			while ($row = mysqli_fetch_row($result)) {
				// $addrs[$i] = strtolower($row[0]);
				$array[] = ["address"=>$row[0], "col2"=>$row[1], "col3"=>'', "date"=>$date, "route"=>$route, "lower"=>strtolower($row[0])];
				$valid = 1;
				// $stmt->bind_param("sssss", $row[0], $addrs[$i], $row[1], $date, $insRoute);
				// $stmt->execute();
				$i++;
			}
			$i = 1;

			while ($row = mysqli_fetch_row($result2)) {
				$key = array_search(strtolower($row[0]), array_column($array, 'lower'));
				 if ($key !== false) {
					$array[$key]['col3'] = $row[1];
					$lc = strtolower($row[0]);
					// $edit->bind_param("ss", $row[1], $lc);
					// $edit->execute();
				 }
				$i++;
			}
		}
			// array_multisort(array_column($array, 'route'), SORT_ASC, $array);
			if ($valid) {
				$prevRoute = $array[0]['route'];
				$scan = 0;
				$prom = 0;
				foreach($array as $row) {
					$route = $row['route'];
					if ($route == $prevRoute) {
						$scan = $scan + $row['col2'];
						$prom = $prom + $row['col3'];
						$prevRoute = $route;
					}
					else {
						$total[$prevRoute] = ['scan'=>$scan, 'prom'=>$prom];
						$scan = $row['col2'];
						$prom = $row['col3'];
						$prevRoute = $route;
					}
				}
				$total[$prevRoute] = ['scan'=>$scan, 'prom'=>$prom];
				$scan = $row['col2'];
				$prom = $row['col3'];
			}
			else {
				$array[] = ["address"=>"No Results Found", "col2"=>'----', "col3"=>'----', "date"=>$date, "route"=>$route, "lower"=>strtolower($route)];
			}
			$fp = fopen('results.json', 'w');
			fwrite($fp, json_encode($array));
			fclose($fp);
			$fp = fopen('totals.json', 'w');
			fwrite($fp, json_encode($total));
			fclose($fp);
	}
	else { // if a route(s) was not provided, go here
		// this is almost identical to the above part, but with no route specified
		$query = "SELECT DISTINCT(Address1), count(*), Route_ID FROM spot_invoice WHERE DATE(PromisedDate) = '".$date."' AND Route_ID IS NOT NULL AND Voided=0 AND Route_ID
		IN (SELECT InstanceID FROM spot_route WHERE Active=1) AND closet_barcode NOT LIKE 'UNKNOWN' GROUP BY Address1";
		$result = $conn->query($query);
		$query2 = "SELECT DISTINCT(spot_group), count(*) FROM spot_invoice_driver_audit WHERE
		DATE(created_on) = '".$date."' GROUP BY spot_group;";
		$result2 = $conn->query($query2);

		$i = 1;
		// $addrs = array();
		// $query = "INSERT INTO results (address, loweredit, col2, date, route) VALUES(?,?,?,?,?)";
		// $stmt = $conn->prepare($query);
		// $editQuery = "UPDATE results SET col3 =? WHERE loweredit =?";
		// $edit = $conn->prepare($editQuery);
		while ($row = mysqli_fetch_row($result)) {
			// $addrs[$i] = strtolower($row[0]);
			$insRoute = $routes[$row[2]];
			$array[] = ["address"=>$row[0], "col2"=>$row[1], "col3"=>'', "date"=>$date, "route"=>$insRoute, "lower"=>strtolower($row[0])];
			// $stmt->bind_param("sssss", $row[0], $addrs[$i], $row[1], $date, $insRoute);
			// $stmt->execute();
			$i++;
		}
		$i = 1;

		while ($row = mysqli_fetch_row($result2)) {
			$key = array_search(strtolower($row[0]), array_column($array, 'lower'));
			if ($key !== false) {
				$array[$key]['col3'] = $row[1];
				$lc = strtolower($row[0]);
				// $edit->bind_param("ss", $row[1], $lc);
				// $edit->execute();
			}
			$i++;
		}
		array_multisort(array_column($array, 'route'), SORT_ASC, $array);
		$prevRoute = $array[0]['route'];
		$scan = 0;
		$prom = 0;
		foreach($array as $row) {
			$route = $row['route'];
			if ($route == $prevRoute) {
				$scan = $scan + $row['col2'];
				$prom = $prom + $row['col3'];
				$prevRoute = $route;
			}
			else {
				$total[$prevRoute] = ['scan'=>$scan, 'prom'=>$prom];
				$scan = $row['col2'];
				$prom = $row['col3'];
				$prevRoute = $route;
			}
		}
		$total[$prevRoute] = ['scan'=>$scan, 'prom'=>$prom];
		$scan = $row['col2'];
		$prom = $row['col3'];
		$fp = fopen('results.json', 'w');
		fwrite($fp, json_encode($array));
		fclose($fp);
		$fp = fopen('totals.json', 'w');
		fwrite($fp, json_encode($total));
		fclose($fp);
	}
});

$app->run();
function getconnection(){
    global $db_host, $db_user, $db_name;
    $conn = mysqli_connect($db_host, $db_user, '', $db_name) or die("Error " . mysqli_error($conn));
    $conn->set_charset("latin1");
    return $conn;
}
?>
