<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <?php 
    include 'includes/stylesheets.inc.php'; 
    include 'includes/dbFunctions.inc.php';
    include 'includes/markupFunctions.inc.php';   
    ?>
    <script>
    
    $(function(){
        
        $("input[name=username]").on("click", function() {
            $('#userError').css('display', 'none');
        });
        
        $("input[name=password]").on("click", function() {
            $('#passError').css('display', 'none');
        });
        
    });
    
    </script>
</head>

<body>
    <?php include 'includes/header.inc.php'; ?>
    <?php include 'includes/stylesheets.inc.php'; ?>
    
    <!-- Page Content -->
    <main class="container">
        <div class="panel panel-default col-md-4 col-md-offset-4">
          <div class="panel-body">
              <form action="loginCookie.php" method="get">
                  <div class="form-group">
                      <label>Username</label>
                      <input type="text" name="username" class="form-control" 
                      value='<?php if (isset($_GET['user']) && !empty($_GET['user'])) { echo $_GET['user']; } ?>'>
                      <label>Password</label>
                      <input type="password" name="password" class="form-control">
                      <button type="submit"  class="btn btn-primary form-control" >Login</button>
                      <?php  if(isset($_GET['userError']) && ($_GET['userError']=="true")) {  ?>
                          <p id="userError"><strong>Username not found.</strong></p>
                      <?php } else if (isset($_GET['passError']) && ($_GET['passError']=="true")) { ?>
                          <p id="passError"><strong>Incorrect password.</strong></p>
                      <?php } ?>
                  </div>
              </form>
          </div>
        </div>      

      
    </main>
    
        <?php include 'includes/footer.inc.php'; ?>

        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>

</html>
