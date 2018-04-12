<!DOCTYPE html>
<html lang="en">

<head>
    <title>About</title>
    <?php 
    include 'includes/stylesheets.inc.php'; 
    include 'includes/dbFunctions.inc.php';
    include 'includes/markupFunctions.inc.php';   
    ?>
</head>

<body>
    <?php include 'includes/header.inc.php'; ?>
    
    <!-- Page Content -->
    <main class="container">
        <div class="panel panel-default row">
          <div class="panel-body col-md-8">
              <h3 style="margin-top: 0;">About Me</h3>
              <p>This assignment was created by Philippe Massicotte and Joanna Payoyo.</p>
              <p>It was created as the second assignment for COMP3512.</p>
          </div>
          <div class="panel-body col-md-4">
                  <h4 style="font-size: 18px">External Resources Used</h4>
                  <ul class="list-unstyled">
                      <li><?php echo makeLink("https://getbootstrap.com", "Bootstrap", '',''); ?></li>
                      <li><?php echo makeLink("", "Project on GitHub", '', ''); ?></li>
                      <li><?php echo makeLink("https://www.amazon.ca/Fundamentals-Web-Development-Randy-Connolly/dp/0134481267/ref=dp_ob_title_bk", "Fundamentals of Web Development Textbook", '',''); ?></li>
                      <li><?php echo makeLink("http://freevector.co/", "Free Vectors", '','')?></li>
                  </ul>
          </div>
        </div>      

      
    </main>
    
        


        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
<?php include 'includes/footer.inc.php'; ?>
</html>
