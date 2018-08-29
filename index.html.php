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
  .btn-custom { /* css for purple search button */
          background-color:#8f61e5 !important;
          color: #fff !important;
  }
  #myForm select {
    width:1550px; }

  #loader {
  position: absolute;
  left: 50%;
  top: 50%;
  z-index: 1;
  width: 150px;
  height: 150px;
  margin: -75px 0 0 -75px;
  border: 16px solid #CCCCFF;
  border-radius: 50%;
  border-top: 16px solid #8f61e5;
  border-bottom: 16px solid #8f61e5;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 1.5s linear infinite;
  animation: spin 1.5s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

  </style>
  <script>
  var subbed = 0;
  </script>
</head>

<body>
  <div id="loader"></div>
  <div id="content" class="wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="page-header clearfix">
          <div class="col-md-12">
            <h2 class="pull-left">Search reports</h2>
          </div>
           <!-- onsubmit="setTimeout(function () { window.location.reload(); }, 12000)" -->
          <form action="http://localhost/dashboard/server/index.php/reports" id="myForm" method="GET" onclick="subbed = 1;">
          <div class="col-md-12">
            <div class="form-group">
              <span>Date:</span>
              <input type="date" min="2000-01-01" max="2050-01-01" name="date" placeholder="mm/dd/yyyy" class="form-control"
              required oninvalid="this.setCustomValidity('Please enter a valid date')" oninput="setCustomValidity('')">
            </div>
            <div class="form-group">
              <span>Route: (optional)</span>
              <select name="route[]" class="form-control" multiple>
                <option value="Apple">Apple</option> <!-- All the routes marked as active -->
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
            <div><button id="buttin" type="submit" class='btn btn-block btn-custom'>Search</button></div>
          </form>
          </div>
        </div>
      </div>
    </div>
    <?php
    $valid = 0;
    $link = mysqli_connect('localhost', 'root', '', 'ppt');
    $result = mysqli_query($link, 'SELECT address, col2, col3, date, route FROM results ORDER BY route');
    while ($row = mysqli_fetch_row($result)) {
       $valid = 1;
       $rows[] = $row;
    }
    include 'table.html.php';
    ?>
  </div>
  <script>
  function showLoad() {
    console.log(subbed);
    if (subbed == 1) {
      console.log("biglulz");
      jQuery('#content').fadeOut(0500);
      jQuery('#loader').fadeIn(0500);
      setTimeout(function () { window.location.reload(); }, 20000);
    };
  };
  </script>
  <script>
    jQuery('#content').hide();
    jQuery('#loader').show();
    jQuery(document).ready(function() {
        jQuery('#loader').fadeOut(1500);
        jQuery('#content').fadeIn(1500);
    });
  </script>
  <script>
     var el = document.getElementById("buttin");
     el.addEventListener("click", showLoad, false);

     $("#buttin").on("click", showLoad());
  </script>

</body>
</html>
