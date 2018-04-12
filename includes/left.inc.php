<!--
JOANNA FINISHED RETROFIT
-->
<?php 
//doesn't need import because this file's include statement always comes after the important includes (db, markup)
function listCountries($connection) {
    $db = new CountriesGateway($connection);
    $statement = $db->findAllJoin('ImageDetails', 'CountryCodeISO', 'CountryName');
    
    //list structure
    echo "<ul class='list-group'>";
    foreach($statement as $row) {
        echo "<li class='list-group-item'>";
        echo makeLink('browse-Images.php?countries='.$row['ISO'], $row['CountryName'], '#', '');
        echo "</li>";
    }
    
    echo "</ul>";
}

function listContinents($connection) {
    $db = new ContinentsGateway($connection);
    $statement = $db->findAll();
    
    //list structure
    echo "<ul class='list-group'>";
    foreach($statement as $row) {
        echo "<li class='list-group-item'>";
        echo makeLink('browse-Images.php?continent='.$row['ContinentCode'], $row['ContinentName'], '#', '');
        echo "</li>";
    }
    
    echo "</ul>";
}

?>

            <aside class="col-md-2">
                <div class="panel left-nav">
                    <div class="panel-heading"><h4>continents</h4></div>
                       <?php listContinents($connection); ?>
                </div>
                <!-- end continents panel -->

                <div class="panel left-nav">
                    <div class="panel-heading"><h4>popular</h4></div>
                       <?php listCountries($connection); ?>
                </div>
                <!-- end countries panel -->
            </aside>