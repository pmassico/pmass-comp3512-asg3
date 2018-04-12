<?php
include 'includes/dbFunctions.inc.php'; 
include 'includes/markupFunctions.inc.php';
require_once('config.php');

if (validImgID($_GET['imgID'])) {
    $imgID = $_GET['imgID'];
} else {
    header('Location: error.php');
    die();
} 
// $pdo = connect();
// $sql = "SELECT Title FROM ImageDetails WHERE ImageID='".$imgID."'";
// $row = $pdo->query($sql);
// $row = $row->fetch();
try {
    $db = new ImageDetailsGateway($connection);
    $statement = $db->findAllParam(array('ImageID','=',$imgID));
    
    $row = $statement[0];
    
} catch(PDOException $e) {
    die($e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <title><?php echo $row['Title']; ?></title>
    <?php include 'includes/stylesheets.inc.php'; ?>
</head>

<body>
    <?php include 'includes/header.inc.php'; ?>
    
    <main class="container">
        <div class="row">
            <?php include 'includes/left.inc.php'; ?>
            <div class="col-md-10">
                <div class="row">
                   
                    <?php
                    try {
                        //get user id from sql1
                        // $sql1 = array("SELECT * FROM ImageDetails WHERE ImageID=?", $_GET['imgID']);
                        // $imgRow = sanitize($pdo, $sql1);
                        // $imgRow = $imgRow->fetch();
                        $db1 = new ImageDetailsGateway($connection);
                        $imgRow = $db1->findAllParam(array('ImageID','=', $_GET['imgID']));
                        $imgRow = $imgRow[0];
                        
                        // $sql2 = "SELECT FirstName, LastName FROM Users WHERE UserID='".$imgRow['UserID']."'";
                        // $userRow = $pdo->query($sql2);
                        // $userRow = $userRow->fetch();
                        $db2 = new UsersGateway($connection);
                        $userRow = $db2->findAllParam(array('UserID','=', $imgRow['UserID']));
                        $userRow = $userRow[0];
                        
                        // $sql3 = array("SELECT CountryName FROM Countries WHERE ISO=?", $imgRow['CountryCodeISO']);
                        // $sql4 = array("SELECT AsciiName FROM Cities WHERE CityCode=?", $imgRow['CityCode']);
                        
                        $db3 = new CountriesGateway($connection);
                        $cnRow = $db3->findAllParam(array('ISO','=', $imgRow['CountryCodeISO']));
                        $cnRow = $cnRow[0];
                        
                        $db4 = new CitiesGateway($connection);
                        $ctRow = $db4->findAllParam(array('CityCode','=', $imgRow['CityCode']));
                        $ctRow = $ctRow[0];
                         
                        // $cnRow = sanitize($pdo, $sql3);
                        // $ctRow = sanitize($pdo, $sql4);
                        
                        // $cnRow = $cnRow->fetch();
                        // $ctRow = $ctRow->fetch();
                        
                        
                        //MAIN (image + desc)
                        echo "<div class='col-md-6'> ";
                        echo "<img class='img-responsive' src='images/medium/".$imgRow['Path']."' alt='".$imgRow['Title']."'>";
                        echo makePanel("description", "<p>".$imgRow['Description']."</p>");
                        echo "</div>";
                        
                        //RIGHT PANEL (credits, )
                        echo "<div class='col-md-4'>";
                        echo "<h3>".$imgRow['Title']."</h3>";
                        
                        echo makePanel("credits", 
                                       "<ul class='details-list'>".
                                        "<li>By: ".makeLink('single-user.php?id='.$imgRow['UserID'], $userRow['FirstName']." ".$userRow['LastName'],'' ,'')."</li>".
                                        "<li>Country: ".makeLink('single-country.php?id='.$imgRow['CountryCodeISO'], $cnRow['CountryName'], '', '')."</li>".
                                        "<li>City: ".makeLink('browse-Images.php?city='.$imgRow['CityCode'], $ctRow['AsciiName'], '', '')."</li>".
                                        "</ul>");
                        echo "<div id='fav-alert' class='alert alert-success' role='alert' style='display:none'>Favourite added!</div>";
                        echo makeImgOptions();
                        
                        echo "<div class='panel panel-default description'>
                                <div class='panel-body'>
                                    <h4>map</h4>
                                    <hr>
                                    <div id='map'></div>
                                </div>
                            </div>";
                            
                        echo "<script type='text/javascript'> 
                            //image from 
                            function initMap() {
                                var uluru = {lat: ".$imgRow['Latitude'].", lng:". $imgRow['Longitude'] ."};
                                var map = new google.maps.Map(document.getElementById('map'), {
                                  zoom: 15,
                                  center: uluru
                                });
                                var marker = new google.maps.Marker({
                                  position: uluru,
                                  map: map
                                });
                              }
                        </script>
                        
                        <script async defer
                        src='https://maps.googleapis.com/maps/api/js?key=$apiKey&callback=initMap'>
                        </script>";
                        
                      } catch (PDOException $e) {
                          die($e->getMessage());
                      }; 
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
