<?php
include 'includes/dbFunctions.inc.php';
include 'includes/markupFunctions.inc.php';
require_once('config.php');

try {
    $db = new PostsGateway($connection);
    $statement = $db->findAllParam(array('PostID','=',$_GET['id']));
    $row = $statement[0];
    
    $db2 = new UsersGateway($connection);
    $statement2 = $db2->findAllParam(array('UserID','=',$row['UserID']));
    $user = $statement2[0];
    
    $db3 = new ImageDetailsGateway($connection);
    $statement3 = $db3->findAllParam(array('ImageID','=',$row['MainPostImage']));
    $mainImg = $statement3[0];
    
    $db4 = new PostImagesGateway($connection);
    $statement5 = $db4->findAllParam(array('PostID','=',$_GET['id']));
    
    $userid = $row['UserID'];
} catch (PDOException $e) { 
    die($e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $row['Title'];?></title>
    <?php include 'includes/stylesheets.inc.php'; ?>
</head>
<body>
    <?php include 'includes/header.inc.php'; ?>
    
    <!-- Page Content -->
    
    
    <main class="container">
        <div class="row">
        <div class="col-md-8 col-md-offset-2">
            
            <?php 
                echo "<h3>".$row['Title']."</h3>"; 
                echo "<p>Posted by <a href='single-user.php?id=".$row['UserID']."'>".$user['FirstName']." ".$user['LastName']."</a>";
                echo " on ".substr($row['PostTime'],0,10)."</p>";
            ?>
        <div id="post" class="panel panel-default">
            <hr/>
          <div class="panel-body">
            <?php 
            try {
                
                
                echo "<img src=images/medium/".$mainImg['Path']." class='img-responsive' style='#' >";
                
                echo "<hr/><h4>Message</h4>";
                echo "<p>".$row['Message']
                ."<div id='fav-alert' class='alert alert-success' role='alert' style='display:none'>Favourite added!</div>"
                .makePostOptions();
                
                echo "</p>";
            } catch (PDOException $e) {
                die( $e->getMessage() );
            }
            
            ?>
          </div>
        </div>     
        
        <div class="panel panel-default">
          <div class="panel-body">
              <h4>images from this post by <?php echo $user['FirstName']." ".$user['LastName'];?></h4>
            <?php
            try {
                generatePosts($connection, $userid);
              } catch (PDOException $e) {
                  die( $e->getMessage() );
               }
            ?>
          </div>
        </div>
        </div>
      </div>
    </main>
    
        <?php include 'includes/footer.inc.php'; ?>


        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>

</html>
