<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <meta charset="utf-8" />
  <title>Invoices</title>

  <style>

  ::selection {
    background: #8f61e5; /* WebKit/Blink Browsers */
    color:#fff;
  }
  ::-moz-selection {
    background: #8f61e5; /* Gecko Browsers */
    color:#fff;
  }

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
  include_once ('config_db.inc.php');
  global $db_host, $db_user, $db_name, $db_pass;
  $ids = array();
  $date = $_GET['date'];
  $comp = $_GET['comp'];
  $link = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
  $query = "select created_on, InvoiceKey, status, phone, EmailAddress, first_name, username, Address1
  FROM spot_invoice_driver_audit WHERE date(created_on)='".$date."' and spot_group='".$comp."' ORDER BY created_on asc"; // gather the needed columns for the company/date
  $result = mysqli_query($link, $query);

  $query2 = "select InvoiceKey FROM spot_invoice WHERE date(PromisedDate) = '".$date."' AND Address1='".$comp."' AND voided=0";
  $result2 = mysqli_query($link, $query2);
?>
<body>
  <div id="loader"></div>
  <div id="content">
  <div class="wrapper">
    <div class="container-fluid">
      <div class="col-sm">
        <div class="row">
          <h2>Scanned Invoices for <?php echo date("m/d/Y", strtotime($date)); ?> at <?php echo $comp; ?> </h2> <!-- Creates a presentable header with company and date -->
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
                  $content = 1;
                  $ids[] = $row[1]; ?>
                  <tr>
                    <?php $date = date("m/d/Y g:i:s A", strtotime($row[0])); ?> <!-- translates datetime to presentable format -->
                    <td><?php echo $date; ?></td>
                    <td><?php echo $row[1]; ?></td>
                    <td><?php echo $row[2]; ?></td>
                    <?php
                    $phone = sprintf("(%s) %s-%s",
                                  substr($row[3], 0, 3),
                                  substr($row[3], 3, 3),
                                  substr($row[3], 6, 4));
                                  // translates phone number to presentable format?>
                    <td><?php echo $phone; ?></td>
                    <td><?php echo $row[4]; ?></td>
                    <td><?php echo $row[5]; ?></td>
                    <td><?php echo $row[6]; ?></td>
                    <td><?php echo $row[7]; ?></td>
                  </tr>
                <?php }
                if (!$content) { // placeholder if company has no scanned invoices
                  echo "<tr>"; ?>
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
        <?php
        $first = 1;
        while ($row = mysqli_fetch_array($result2)) {
          if (!in_array($row[0], $ids)) {
            if ($first) { ?>
        <h2>Non-Scanned Invoices for <?php echo date("m/d/Y", strtotime($date)); ?> at <?php echo $comp; ?></h2>
          <div class="col-sm">
            <table class="table table-hover table-striped">
              <thead>
                <tr class='bg-dark text-white'>
                  <th scope="col">Invoice Key</th>
                </tr>
              </thead>
            <?php } $first = 0; ?>
              <tbody>
                    <tr>
                      <td><?php echo $row[0]; ?></td>
                    </tr>
          <?php  }
               }
                mysqli_close($link); ?>
              </tbody>
            </table>
          </div>
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
