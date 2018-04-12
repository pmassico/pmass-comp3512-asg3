<?php
include 'includes/dbFunctions.inc.php';
include 'includes/markupFunctions.inc.php';
require_once('config.php');

if (validUserID($_GET['id'])) {
    //continue
} else {
    header('Location: error.php');
    die();
} 

?>

<!DOCTYPE html>
<html lang="en">
<?php 
    try {
        $db = new UsersGateway($connection);
        $statement = $db->findAllParam(array('UserID','=',$_GET['id']));
        $row = $statement[0];
    } catch(PDOException $e) {
        die($e->getMessage());
    }
?>

<head>
    <title><?php echo "Profile - " . $row['LastName'] . ", " . $row['FirstName'];?></title>
    <?php include 'includes/stylesheets.inc.php';  ?>
</head>

<body>
    <?php include 'includes/header.inc.php'; ?>
    
    <!-- Page Content -->
    
    
    <main class="container">
        <div class="panel panel-default">
          <div class="panel-body">
            <?php 
            try {
                echo "<h3 style='margin-top: 0;'>".$row['FirstName']. " " .$row['LastName']."</h3>";
                echo "<p>".$row['Address']."</strong></p>";
                echo "<p>".$row['City']. ", " .$row['Postal']. ", " .$row['Country']."</p>";
                echo "<p>".$row['Phone']."</p>";
                echo "<p>".$row['Email']."</p>";
            } catch (PDOException $e) {
                die( $e->getMessage() );
            }
            
            ?>
          </div>
        </div>     
        
        <div class="panel panel-default">
          <div id="preview-images" class="panel-body">
              <h4>images by <?php echo $row['FirstName'] . " " . $row['LastName'];?></h4>
            <?php generateImages($connection); ?>
          </div>
        </div>     

      
    </main>
    
        <?php include 'includes/footer.inc.php'; ?>


        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>

</html>
