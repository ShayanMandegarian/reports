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
  <h2>Search reports:</h2>

  <div class="wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="page-header clearfix">
          <form action="http://localhost/pt_admin/server/index.php/reports" method="GET">
          <div class="col-md-12">
            <div class="form-group">
              <!-- <label for="date">Date:</label> -->
              <span>Date:</span>
              <input type="date" name="date" size="256" class="form-control">
            </div>
            <div class="form-group">
              <span>Route: (optional)</span>
              <input type="text" name="route" size="256" class="form-control" placeholder="eg. MT01">
            </div>
            <div><input type="submit" class='btn btn-block btn-royal' value="Search"/></div>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
