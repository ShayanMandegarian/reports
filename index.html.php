<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
  <meta charset="utf-8" />
  <title>Reports</title>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#search').click(function() {
        goUrl = 'http://localhost/pt_admin/server/index.php/reports'
      });
    });
  </script>

</head>

<body>
  <h2>Search reports:</h2>

  <div class="wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="page-header clearfix">
          <form action="http://localhost/pt_admin/server/index.php/reports" id="myForm" method="GET">
          <div class="col-md-12">
            <div class="form-group">
              <span>Date:</span>
              <input type="date" name="date" minlength="1" size="256" placeholder="mm/dd/yyyy" class="form-control">
            </div>
            <div class="form-group">
              <span>Route: (optional)</span>
              <input type="text" name="route" size="256" class="form-control" placeholder="eg. MT01">
            </div>
            <div><button class='btn btn-block btn-primary'>Search</button></div>
          </form>
            <br>
            <div><button type="button" onclick="location.href='http://localhost/dashboard/table'" class='btn btn-block btn-success'>Go To Latest Report</button></div>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
