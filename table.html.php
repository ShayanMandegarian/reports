<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <meta charset="utf-8" />
  <title>Reports</title>
</head>

<?php
$link = mysqli_connect('localhost', 'root');

if(!mysqli_set_charset($link, 'utf8'))
{
  $error = 'Unable to decode database, not UTF-8.';
  include 'err.html.php';
  exit();
}

if(!mysqli_select_db($link, 'ppt'))
{
  $error = 'Unable to connect to the PurpleTie database.';
  include 'err.html.php';
  exit();
}

$result = mysqli_query($link, 'SELECT address, col2, col3 FROM results');
if (!$result)
{
  $error = 'Error fetching users: ' . mysqli_error($link);
  include 'err.html.php';
  exit();
}

while ($row = mysqli_fetch_row($result)) {
   $rows[] = $row;
}
?>

<body>
  <div class="wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="page-header clearfix">
            <h2 class="pull-left">Report Details</h2>
            <table class="table table-boarded table-striped">
              <thead>
                <tr>
                  <th>Address</th>
                  <th>Promised</th>
                  <th>Scanned</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($rows as $row) { ?>
                  <tbody>
                    <tr>
                      <?php echo "<td>". $row[0] ."</td>"; ?>
                      <?php echo "<td>". $row[1] ."</td>"; ?>
                      <?php echo "<td>". $row[2] ."</td>"; ?>
                    </tr>
                  </tbody>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
