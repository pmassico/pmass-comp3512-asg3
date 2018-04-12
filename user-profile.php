<?php
include 'includes/dbFunctions.inc.php';
require_once('config.php');

if(!isset($_COOKIE['login'])) {
    header('Location:login.php');
}

try {
    $db = new UsersGateway($connection);
    $statement = $db->findAllParam(array('UserID','=',$_COOKIE['login']));
    $row = $statement[0];
} catch(PDOException $e) {
    die($e->getMessage());
}
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo "Profile - " . $row['LastName'] . ", " . $row['FirstName'];?></title>
    <?php include 'includes/stylesheets.inc.php'; ?>
</head>

<body>
    <?php include 'includes/header.inc.php'; ?>
    
    <!-- Page Content -->
    
    
    <main class="container">
        <div class="row">
        <div class="col-md-6 col-xs-6 text-center">
            <img src="images/misc/user.png" alt="user" width="50%">
        </div>
        <div class="panel panel-default col-md-6 col-xs-6">
            <div class="panel-header">
                <h2>User Profile</h2>
            </div>
          <div class="panel-body">
              
              <table class="table user-profile">
                  <?php try { ?>
                  <tr>
                      <th scope="row">name: </th>
                      <th scope="row"><?php echo $row['FirstName']." ".$row['LastName'];?></th>
                  </tr>
                  <tr>
                      <th scope="row">address: </th>
                      <th scope="row"><?php echo $row['Address'];?></th>
                  </tr>
                  <tr>
                      <th scope="row">city: </th>
                      <th scope="row"><?php echo $row['City'];?></th>
                  </tr>
                  <tr>
                      <th scope="row">postal code: </th>
                      <th scope="row"><?php echo $row['Postal'];?></th>
                  </tr>
                  <tr>
                      <th scope="row">country: </th>
                      <th scope="row"><?php echo $row['Country'];?></th>
                  </tr>
                  <tr>
                      <th scope="row">phone: </th>
                      <th scope="row"><?php echo $row['Phone'];?></th>
                  </tr>
                  <tr>
                      <th scope="row">email: </th>
                      <th scope="row"><?php echo $row['Email'];?></th>
                  </tr>
                  
              </table>
              
            <?php
                } catch (PDOException $e) {
                    die( $e->getMessage() );
                }
            ?>
          </div>
        </div>        

      </div>
    </main>
    
        <?php include 'includes/footer.inc.php'; ?>


        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>

</html>
