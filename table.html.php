<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <meta charset="utf-8" />
  <title>Reports</title>

  <style>
  a {
    color: black;
  }
  a:hover {
    color: #8f61e5;
  } /* css to make the links text black and turn purple when hovering over */
  </style>
</head>

<body>
  <div class="wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="page-header clearfix">
            <h2 class="pull-left">Report Details
            <?PHP
            echo "for ".date("m/d/Y", strtotime($date)); // convert date to a presentable format
            $currDate = $date;
            ?></h2>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Address</th>
                  <th scope="col">Promised</th>
                  <th scope="col">Scanned</th>
                </tr>
              </thead>
              <tbody>
                <?php
                        $prevRoute = '';
                        foreach($array as $row) {
                          if ($routeGiven == 0 || ($routeGiven == 1 && in_array($row['route'], $routes))) { // if no routes given, or the current row has a route that was searched for
                          $company = $row['address'];
                          $mismatch = 0;
                          $route = $row['route'];
                        if ($row['col2'] != $row['col3']) {
                            $mismatch = 1); // calculate if col2 and col3 are different
                          } ?>
                  <tbody>
                      <?php if ($mismatch == 0) { // if col2 and col3 are the same...
                              if ($route != $prevRoute) {
                                echo "<tr class='bg-dark text-white'>";
                                echo "<td>".$route."</td>";
                                if (array_key_exists($route, $total)) {
                                  echo "<td>".$total[$route]['scan']."</td>";
                                  echo "<td>".$total[$route]['prom']."</td>";
                                }
                                else {
                                  echo "<td>----</td>"; // placeholder
                                  echo "<td>----</td>";
                                }
                              }
                              echo "<tr>";
                         echo "<td>";
                         echo"<a href='company?date=$currDate&comp=$company'>$company</a>"; // makes col1 a link to invoices for that company/date
                         echo "</td>";
                         echo "<td>". $row['col2'] ."</td>";
                         echo "<td>". $row['col3'] ."</td>";
                         if ($row['route'] != '') {
                                $prevRoute = $row['route'];
                              }
                            }
                            else { // if col2 and col3 are different, highlight row
                              if ($route != $prevRoute) {
                                echo "<tr class='bg-dark text-white'>";
                                echo "<td>".$route."</td>";
                                if (array_key_exists($route, $total)) {
                                  echo "<td>".$total[$route]['scan']."</td>";
                                  echo "<td>".$total[$route]['prom']."</td>";
                                }
                                else {
                                  echo "<td>----</td>"; // placeholder
                                  echo "<td>----</td>";
                                }
                              }
                              echo "<tr class='table-secondary'>";
                              echo "<td><b><i>";
                              echo "<a href='company?date=$currDate&comp=$company'>$company</a>"; // makes col1 a link to invoices for that company/date
                              echo "</i></b></td>";
                              echo "<td><b><i>". $row['col2'] ."</i></b></td>";
                              echo "<td><b><i>". $row['col3'] ."</i></b></td>";
                              if ($row['route'] != '') {
                                $prevRoute = $row['route'];
                              }
                            }?>
                    </tr>
                  </tbody>
                <?php }} ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
