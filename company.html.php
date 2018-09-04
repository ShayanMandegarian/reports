<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <meta charset="utf-8" />
  <title>Reports</title>

  <style>
  .btn-custom { /* css for purple button */
          background-color:#8f61e5 !important;
          color: #fff !important;
  }
  #loader {
  position: fixed;
  left: 50%;
  top: 50%;
  z-index: 1;
  width: 150px;
  height: 150px;
  margin: -75px 0 0 -75px;
  border: 36px groove #CCCCFF;
  border-radius: 50%;
  border-top: 36px groove #8f61e5;
  border-bottom: 36px groove #8f61e5;
  width: 220px;
  height: 220px;
  -webkit-animation: spin 1.2s infinite;
  animation: spin 1.2s  infinite;
  }

  @-webkit-keyframes spin {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(359.9999999999deg); }
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(359.99999999999deg); }
  }
  </style>

</head>
<?PHP
  $date = $_GET['date'];
  $comp = $_GET['comp'];
  $link = mysqli_connect('localhost', 'root', '', 'ppt');
  $query = "select created_on, InvoiceKey, status, phone, EMailAddress, first_name, username, Address1
  FROM spot_invoice_driver_audit WHERE date(created_on)='".$date."' and spot_group='".$comp."' ORDER BY created_on asc";
  $result = mysqli_query($link, $query);
?>
<body>
  <div id="loader"></div>
  <div id="content">
  <div class="wrapper">
    <div class="container-fluid">
      <div class="col-sm">
        <div class="row">
          <h2>Invoices for <?php echo date("m/d/Y", strtotime($date)); ?> at <?php echo $comp; ?> </h2>
          <div class="col-sm" style="margin:5px">
            <div class="container-fluid">
              <button onclick="jQuery('#content').fadeOut(1500); jQuery('#loader').fadeIn(1500); window.history.back();" class="btn btn-custom btn-md float-right">Back</button>
            </div>
          </div>
        </div>
          <div class="page-header clearfix">
            <table class="table table-hover table-striped">
              <thead>
                <tr class='bg-dark text-white'>
                  <th scope="col">Scan DateTime</th>
                  <th scope="col">Invoice Key</th>
                  <th scope="col">Status</th>
                  <th scope="col">Customer Phone</th>
                  <th scope="col">Customer Email</th>
                  <th scope="col">Customer Name</th>
                  <th scope="col">Driver Name</th>
                  <th scope="col">Location</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $content = 0;
                while ($row = mysqli_fetch_array($result)) {
                  $content = 1; ?>
                  <tr>
                    <?php $date = date("m/d/Y g:i:s A", strtotime($row[0])); ?>
                    <td><?php echo $date; ?></td>
                    <td><?php echo $row[1]; ?></td>
                    <td><?php echo $row[2]; ?></td>
                    <?php
                    $phone = sprintf("(%s) %s-%s",
                                  substr($row[3], 0, 3),
                                  substr($row[3], 3, 3),
                                  substr($row[3], 6, 4)); ?>
                    <td><?php echo $phone; ?></td>
                    <td><?php echo $row[4]; ?></td>
                    <td><?php echo $row[5]; ?></td>
                    <td><?php echo $row[6]; ?></td>
                    <td><?php echo $row[7]; ?></td>
                  </tr>
                <?php }
                if (!$content) {
                  echo "<tr>";
                    // $date = date("m/d/Y g:i:s A", strtotime($row[0])); ?>
                    <td><?php echo "None"; ?></td>
                    <td><?php echo "None"; ?></td>
                    <td><?php echo "None"; ?></td>
                    <td><?php echo "None"; ?></td>
                    <td><?php echo "None"; ?></td>
                    <td><?php echo "None"; ?></td>
                    <td><?php echo "None"; ?></td>
                    <td><?php echo "None"; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    jQuery('#loader').hide();
  </script>
</body>
</html>
