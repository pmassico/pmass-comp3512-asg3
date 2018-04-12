<?php
include 'includes/markupFunctions.inc.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Home</title>
  <?php include 'includes/stylesheets.inc.php'; ?>
</head>

<body>
    <?php include 'includes/header.inc.php'; ?>
    
    <!-- Page Content -->
    <main class="container">
       <?php 
    //   echo generateThumbnail("Countries", "See countries that have images.");
    //   echo generateThumbnail("Images", "See all of our travel images.");
    //   echo generateThumbnail("Users", "See information about users.");
       ?>
       <div class="row text-center">
           <div class='col-md-4 col-sm-4 index-nav'>
               <figure>
                    <img src="images/misc/map.png" width="70%">
                <figcaption>
                    <a href="browse-Countries.php"><h1>COUNTRIES</h1></a>
                </figcaption>
                </figure>
           </div>
           <div class='col-md-4 col-sm-4 index-nav'>
               <figure>
                    <img src="images/misc/camera.png" width="70%">
                <figcaption>
                    <a href="browse-Images.php"><h1>IMAGES</h1></a>
                </figcaption>
                </figure>
           </div>
           <div class='col-md-4 col-sm-4 index-nav'>
               <figure>
                    <img src="images/misc/users.png" width="70%">
                <figcaption>
                    <a href="browse-Users.php"><h1>USERS</h1></a>
                </figcaption>
                </figure>
           </div>
           </ul>
       </div>
    </main>
    
    <footer>
        <?php include 'includes/footer.inc.php'; ?>
    </footer>


        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>

</html>
