<?php
require_once('config.php');

function displayCountries($connection) {
  try { 
    $db = new CountriesGateway($connection);
    $statement = $db->findAllJoin('ImageDetails', 'CountryCodeISO', 'CountryName');
    
    foreach($statement as $row) {
      echo "<li class='list-group-item col-md-6 col-xs-6'>";
      echo "<a href='single-country.php?id=".$row['ISO']."'  >"
      .$row['CountryName']."</a>";
      echo "</li>";
    }
  } catch (PDOException $e) {
      die( $e->getMessage() );
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Browse countries</title>
    <?php include 'includes/stylesheets.inc.php';  ?>
</head>

<body>
    <?php include 'includes/header.inc.php'; ?>
    
    <!-- Page Content -->
    <main class="container">
      <h3>Countries</h3>
        <div class="panel panel-default">
          <div class="panel-body browse-list">
            <ul class="list-group browse-list-ul row">
              <?php displayCountries($connection); ?>
            </ul>
          </div>
        </div>     

      
    </main>
    
        <?php include 'includes/footer.inc.php'; ?>


        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>

</html>
