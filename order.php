
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Order Confirmation</title>
    <?php 
    include 'includes/dbFunctions.inc.php';
    include 'includes/markupFunctions.inc.php';   
    include 'config.php';
    ?>
    <script>
    </script>
</head>

<body>
    <?php include 'includes/header.inc.php'; ?>
    <?php include 'includes/stylesheets.inc.php'; ?>
    
    <!-- Page Content -->
    <main class="container">
        <table class="table panel panel-default" >
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Size</th>
                    <th>Paper</th>
                    <th>Frame</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                $num = 1;
                
                while(isset($_GET['title'.$num])) {
                    try {
                        $db = new ImageDetailsGateway($connection);
                        $statement = $db->findAllParam(array('ImageDetails.Title',' LIKE ','%'.$_GET['title'.$num].'%'));
                        $row = $statement[0];
            ?>
                <tr>
                    <td><img src="images/square-small/<?php echo $row['Path']; ?>" alt="<?php echo $row['Title']; ?>" /></td>
                    <td id="size<?php echo $_GET['size'.$num]; echo $num; ?>"></td>
                    <td id="paper<?php echo $_GET['paper'.$num]; echo $num; ?>"></td>
                    <td id="frame<?php echo $_GET['frame'.$num]; echo $num; ?>"></td>
                    <td><?php echo $_GET['qty'.$num]; ?></td>
                </tr>
            <?php      
                    } catch(PDOException $e) {
                        die($e->getMessage());
                    }
                    
                    $num++;
                }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan=4></td>
                    <td id="ship<?php echo $_GET['ship']; ?>"></td>
                </tr>
            </tfoot>
        </table>

      
    </main>
    
        <?php include 'includes/footer.inc.php'; ?>
        
        <script src="js/order_js.js"></script>
        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>

</html>
