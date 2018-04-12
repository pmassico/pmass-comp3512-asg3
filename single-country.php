
<?php
include 'includes/dbFunctions.inc.php';
include 'includes/markupFunctions.inc.php';
include 'config.php';

function outputMap($country, $apiKey) {
    // format: the%20united%20states
    $formattedCountry = str_replace(" ","%20", $country);
    
    $html = "<div>";
    $html = "<iframe style='border:0' width='400px' height='200px'";
    $html .= "src='https://www.google.com/maps/embed/v1/place?q=$formattedCountry&key=$apiKey&zoom=8' "; 
    $html .= "allowfullscreen></iframe>";
    $html .= "</div>";
    return $html;
}

try {
    $db = new CountriesGateway($connection);
    $statement = $db->findAll();
    
    foreach($statement as $row) {
        // load all ISOs into countries array
        $countries[] = $row['ISO'];
    }
} catch(PDOException $e) {
    die($e->getMessage());
}

if (validCountry($_GET['id'], $countries)) {
    //continue
} else {
    header('Location: error.php');
} 


try {
    $statement = $db->findAllParam(array('ISO','=',$_GET['id']));
    $row = $statement[0];
    $country = $row['CountryName'];
} catch (PDOException $e) { 
    die($e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $row['CountryName']; ?></title>
    <?php include 'includes/stylesheets.inc.php'; ?>
</head>
<body>
    <?php include 'includes/header.inc.php'; ?>
    
    <!-- Page Content -->
    
    
    <main class="container">
        <h3><?php echo $row['CountryName']; ?></h3>
        
        <div class='panel panel-default col-md-12'>
            <h4>description</h4>
            <p> <?php echo $row['CountryDescription']; ?></p>
        </div>
        
            <div id="facts" class='panel panel-default col-md-6'>
                <h4>facts</h4>
                <table>
                    <tr><td><h5>capital:</h5></td><td><p><?php echo $row['Capital']; ?></p></td></tr>
                    <tr><td><h5>area:</h5></td><td><p><?php echo number_format($row['Area']); ?></p></td></tr>
                    <tr><td><h5>population:</h5></td><td><p><?php echo number_format($row['Population']); ?></p></td></tr>
                    <tr><td><h5>currency:</h5></td><td><p><?php echo $row['CurrencyName']; ?></p></td></tr>
                </table>
            </div>
           
         
        <div id="map" class='panel panel-default col-md-6'>
            <h4>map</h4>
            <?php echo outputMap($country, $apiKey); ?>  
        </div>
        
        <div id='preview-images' class='panel panel-default col-md-12'>
                <h4>images</h4>
                <?php generateImages($connection); ?>
        </div>
      
    </main>
    
        <?php include 'includes/footer.inc.php'; ?>


        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>

</html>
