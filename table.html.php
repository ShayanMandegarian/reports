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
  }
  </style>
</head>

<body>
  <div class="wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="page-header clearfix">
            <h2 class="pull-left">Report Details
            <?PHP if ($valid == 1) {
                    echo "for ".date("m/d/Y", strtotime($rows[0]['date']));
                    $currDate = $rows[0]['date'];
                  }

            ?></h2>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Address</th>
                  <th scope="col">Promised</th>
                  <th scope="col">Scanned</th>
                  <!-- <th scope="col">Route</th> -->

                </tr>
              </thead>
              <tbody>
                <?php if ($valid == 1) {
                        $prevRoute = '';
                        // $i = 1;
                        foreach($rows as $row) {
                          $company = $row['address'];
                          $mismatch = 0;
                          $route = $row['route'];
                        if (($row['col2'] != $row['col3']) /*&& ($row[2] != '')*/) {
                            $mismatch = abs($row['col2'] - $row['col3']);
                          } ?>
                  <tbody>
                      <?php if ($mismatch == 0) {
                              if ($route != $prevRoute) {
                                echo "<tr class='bg-dark text-white'>";
                                echo "<td>".$route."</td>";
                                if (array_key_exists($route, $totalRow)) {
                                  echo "<td>".$totalRow[$route]['scan']."</td>";
                                  echo "<td>".$totalRow[$route]['prom']."</td>";
                                }
                                else {
                                  echo "<td>----</td>";
                                  echo "<td>----</td>";
                                }
                              }
                              echo "<tr>";?>
                        <?php echo "<td>"; ?>
                        <?php echo"<a href='company?date=$currDate&comp=$company'>$company</a>"; ?>
                        <?php echo "</td>"; ?>
                        <?php echo "<td>". $row['col2'] ."</td>"; ?>
                        <?php echo "<td>". $row['col3'] ."</td>"; ?>
                        <?php if ($row['route'] != '') {
                                // echo "<td>". $row['route'] ."</td>";
                                $prevRoute = $row['route'];
                              }
                            }
                            else {
                              if ($route != $prevRoute) {
                                echo "<tr class='bg-dark text-white'>";
                                echo "<td>".$route."</td>";
                                if (array_key_exists($route, $totalRow)) {
                                  echo "<td>".$totalRow[$route]['scan']."</td>";
                                  echo "<td>".$totalRow[$route]['prom']."</td>";
                                }
                                else {
                                  echo "<td>----</td>";
                                  echo "<td>----</td>";
                                }
                              }
                              echo "<tr class='table-secondary'>";
                              echo "<td><b><i>";
                              echo "<a href='company?date=$currDate&comp=$company'>$company</a>";
                              echo "</i></b></td>";
                              echo "<td><b><i>". $row['col2'] ."</i></b></td>";
                              echo "<td><b><i>". $row['col3'] ."</i></b></td>";
                              if ($row['route'] != '') {
                                // echo "<td>". $row['route'] ."</td>";
                                $prevRoute = $row['route'];
                              }
                            }?>
                    </tr>
                  </tbody>
                <?php //$i++;
              }} ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
