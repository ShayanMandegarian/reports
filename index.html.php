<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
  <meta charset="utf-8" />
  <title>Reports</title>

  <style>
  .btn-custom {
          background-color:#8f61e5 !important;
          color: #fff !important;
  }
  #myForm select {
    width:1550px; }
  </style>

</head>

<body>
  <div class="wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="page-header clearfix">
          <div class="col-md-12">
            <h2 class="pull-left">Search reports</h2>
          </div>
          <form action="http://localhost/dashboard/server/index.php/reports" id="myForm" method="GET" onsubmit="setTimeout(function () { window.location.reload(); }, 10000)">
          <div class="col-md-12">
            <div class="form-group">
              <span>Date:</span>
              <input type="date" min="2000-01-01" max="2050-01-01" name="date" minlength="1" size="256" placeholder="mm/dd/yyyy" class="form-control"
              required oninvalid="this.setCustomValidity('Please enter a valid date')" oninput="setCustomValidity('')">
            </div>
            <div class="form-group">
              <span>Route: (optional)</span>
              <select name="route[]" style="max-width:500%;" class="form-control" multiple>
                <option value="Apple">Apple</option>
                <option value="Facebook">Facebook</option>
                <option value="Facebook*">Facebook*</option>
                <option value="Genentech">Genentech</option>
                <option value="Google">Google</option>
                <option value="Intel">Intel</option>
                <option value="MT01">MT01</option>
                <option value="MT02">MT02</option>
                <option value="MT03">MT03</option>
                <option value="MT04">MT04</option>
                <option value="MT05">MT05</option>
                <option value="MT06">MT06</option>
                <option value="MT08">MT08</option>
                <option value="MT09">MT09</option>
                <option value="MTtemp">MTtemp</option>
                <option value="TF01">TF01</option>
                <option value="TF02">TF02</option>
                <option value="TF03">TF03</option>
                <option value="TF04">TF04</option>
                <option value="TF05">TF05</option>
                <option value="TF06">TF06</option>
                <option value="TF07">TF07</option>
                <option value="TF08">TF08</option>
                <option value="Oracle">Oracle</option>
                <option value="Palantir">Palantir</option>
                <option value="RWC">RWC</option>
                <option value="StorageDonations">StorageDonations</option>
              </select>
            </div>
            <div><button type="submit" class='btn btn-block btn-custom'>Search</button></div>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?PHP include 'table.html.php';?>
</body>
</html>
