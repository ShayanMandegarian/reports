<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <meta charset="utf-8" />
  <title>Reports</title>
</head>

<body>
  <div class="wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="page-header clearfix">
            <h2 class="pull-left">Report Details
            <?PHP if ($valid == 1)
                    echo "for ".$rows[0][3];
            ?></h2>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Address</th>
                  <th scope="col">Scanned</th>
                  <th scope="col">Promised</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($valid == 1) {
                        $prevRoute = '';
                        foreach($rows as $row) {
                          $mismatch = 0;
                          $route = $row[4];
                          if (($row[1] != $row[2]) && ($row[2] != '')) {
                            $mismatch = abs($row[1] - $row[2]);
                          } ?>
                  <tbody>
                      <?php if ($mismatch == 0) {
                              if ($route != $prevRoute) {
                                echo "<tr class='bg-dark text-white'>";
                                echo "<td>".$route."</td>";
                                echo "<td>----</td>";
                                echo "<td>----</td>";
                              }
                              echo "<tr>";?>
                        <?php echo "<td>". $row[0] ."</td>"; ?>
                        <?php echo "<td>". $row[1] ."</td>"; ?>
                        <?php echo "<td>". $row[2] ."</td>"; ?>
                        <?php if ($row[4] != '') {
                                // echo "<td>". $row[4] ."</td>";
                                $prevRoute = $row[4];
                              }
                            }
                            else if ($mismatch > 3){
                              if ($route != $prevRoute) {
                                echo "<tr class='bg-dark text-white'>";
                                echo "<td>".$route."</td>";
                                echo "<td>----</td>";
                                echo "<td>----</td>";
                              }
                              echo "<tr class='table-danger'>";
                              echo "<td>". $row[0] ."</td>";
                              echo "<td>". $row[1] ."</td>";
                              echo "<td>". $row[2] ."</td>";
                              if ($row[4] != '') {
                                // echo "<td>". $row[4] ."</td>";
                                $prevRoute = $row[4];
                              }
                            }
                            else {
                              if ($route != $prevRoute) {
                                echo "<tr class='bg-dark text-white'>";
                                echo "<td>".$route."</td>";
                                echo "<td>----</td>";
                                echo "<td>----</td>";
                              }
                              echo "<tr class='table-warning'>";
                              echo "<td>". $row[0] ."</td>";
                              echo "<td>". $row[1] ."</td>";
                              echo "<td>". $row[2] ."</td>";
                              if ($row[4] != '') {
                                // echo "<td>". $row[4] ."</td>";
                                $prevRoute = $row[4];
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
