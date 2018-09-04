<?php
include_once ('config_db.inc.php');
include_once ('sec_funcs.php');
require 'server/Slim/Slim.php';
\Slim\Slim::registerAutoloader();

if (isset($_GET['date'])) {
  $date = $_GET['date'];
}
else {
  header ('Location: .');
}
$route = ''; // declare route variable
$conn = getconnection();
$array = array();
$total = array();

if (isset($_GET['route']) && $_GET['route'] != '' ) { //if a route is provided, go here
  //declare variables before loop to prevent deletion of content
  foreach ($_GET['route'] as $route) { //loops through each route provided
    $routeQuery = "SELECT InstanceID FROM spot_route WHERE RouteName LIKE '".$route."'";
    $routeResult = $conn->query($routeQuery);
    $rrRow = mysqli_fetch_row($routeResult);
    $routeId = $rrRow[0]; // translates route name to routeId to be used in spot_invoice

    $query = "SELECT DISTINCT(Address1), count(*), Route_ID FROM spot_invoice WHERE DATE(PromisedDate) = '".$date."' AND Route_ID = '".$routeId."' AND Voided=0 AND Route_ID
    IN (SELECT InstanceID FROM spot_route WHERE Active=1) AND closet_barcode NOT LIKE 'UNKNOWN' GROUP BY Address1";
    $result = $conn->query($query); //get address and promised columns

    $query2 = "SELECT DISTINCT(spot_group), count(*) FROM spot_invoice_driver_audit WHERE
    DATE(created_on) = '".$date."' GROUP BY spot_group;";
    $result2 = $conn->query($query2); //get scanned column

    $valid = 0;
    while ($row = mysqli_fetch_row($result)) {
      $array[] = ["address"=>$row[0], "col2"=>$row[1], "col3"=>'', "date"=>$date, "route"=>$route, "lower"=>strtolower($row[0])];
      $valid = 1;
    }

    while ($row = mysqli_fetch_row($result2)) {
      $key = array_search(strtolower($row[0]), array_column($array, 'lower'));
       if ($key !== false) {
        $array[$key]['col3'] = $row[1];
        $lc = strtolower($row[0]);
       }
    }
  }
    $conn->close();
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
}
else { // if a route(s) was not provided, go here
  // this is almost identical to the above part, but with no route specified
  $query = "SELECT Address1, count(*), Route_ID from spot_invoice where date(PromisedDate) = '".$date."'
  and Voided=0 and Route_ID in (select InstanceID from spot_route where Active=1) and closet_barcode not like 'UNKNOWN'
  group by Address1 order by Address1 asc";
  $result = $conn->query($query);

  $query2 = "SELECT DISTINCT(spot_group), count(*) FROM spot_invoice_driver_audit WHERE
  DATE(created_on) = '".$date."' GROUP BY spot_group";
  $result2 = $conn->query($query2);

  $valid = 0;
  while ($row = mysqli_fetch_row($result)) {
    $routeQuery = "SELECT RouteName FROM spot_route WHERE InstanceID LIKE '".$row[2]."'";
    $routeResult = $conn->query($routeQuery);
    $rrRow = mysqli_fetch_row($routeResult);
    $routeId = $rrRow[0];
    $array[] = ["address"=>$row[0], "col2"=>$row[1], "col3"=>'', "date"=>$date, "route"=>$routeId, "lower"=>strtolower($row[0])];
    $valid = 1;
  }

  while ($row = mysqli_fetch_row($result2)) {
    $key = array_search(strtolower($row[0]), array_column($array, 'lower'));
    if ($key !== false) {
      $array[$key]['col3'] = $row[1];
      $lc = strtolower($row[0]);
    }
  }
  $conn->close();
  array_multisort(array_column($array, 'route'), SORT_ASC, $array);
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
}
include 'index2.html.php';

function getconnection(){
    global $db_host, $db_user, $db_name;
    $conn = mysqli_connect($db_host, $db_user, '', $db_name) or die("Error " . mysqli_error($conn));
    $conn->set_charset("latin1");
    return $conn;
}
?>
