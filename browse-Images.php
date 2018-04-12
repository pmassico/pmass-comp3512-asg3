<!---->
<!--JOANNA FINISHED THE PAGE-->
<!---->
<?php
include 'config.php';

//TODO: join to only select options that have images
function outputOptions($type, $connection) {
  //continent, country, or city
  try {
    if ($type == "continent") {
      $db = new ContinentsGateway($connection);
      $statement = $db->findAllJoin('ImageDetails', 'ContinentCode', 'ContinentName');
      $optionValue = 'ContinentName';
      $optionKey = 'ContinentCode';
    } else if ($type == "countries") {
      $db = new CountriesGateway($connection);
      $statement = $db->findAllJoin('ImageDetails', 'CountryCodeISO', 'CountryName');
      $optionValue = 'CountryName';
      $optionKey = 'ISO';
    } else if ($type == "cities") {
      $db = new CitiesGateway($connection);
      $statement = $db->findAllJoin('ImageDetails', 'CityCode', 'AsciiName');
      $optionValue = 'AsciiName';
      $optionKey = 'CityCode';
    }

    foreach ($statement as $row) {
      $options = "<option value=".$row[$optionKey].">"; 
      $options.= $row[$optionValue];
      $options.= "</option>";
      
      echo $options;
    }
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}
              
function outputDrop ($type, $connection) {
  echo "<select name=$type>
        <option value=''>Select $type</option>";
  outputOptions($type, $connection);
  echo "</select>";
}

function getSearch() {
  $url = $_SERVER['PHP_SELF'] ."?". $_SERVER['QUERY_STRING'];
  
  if ($url == "/assignment1/browse-Images.php?") {
    return " [ALL]";
  } else {
   if (isset($_GET['countries']) && $_GET['countries'] != "") { return " [Country=".$_GET['countries']."]";   } 
   if (isset($_GET['continent']) && $_GET['continent'] != "") { return " [Continent=".$_GET['continent']."]"; }
   if (isset($_GET['cities']) && $_GET['cities'] != "")       { return " [CityID=".$_GET['cities']."]";       }
   if (isset($_GET['cities']) && !empty($_GET['title']))      { return " [Title=".$_GET['title']."]";         }
   if (isset($_GET['search']))                                { return " [Search=".$_GET['search']."]";       }
  }
}

function outputImage($connection) {
  $url = $_SERVER['PHP_SELF'] ."?".$_SERVER['QUERY_STRING'];
  $statement = array();
  $db = new ImageDetailsGateway($connection);
  
  try {
    if ($url == "/assignment1/browse-Images.php?") {
      $statement = $db->findAll();
    } else {
      if (isset($_GET['countries']) && $_GET['countries'] != "0" && !empty($_GET['countries']))     { 
        $statement = $db->findAllParam(array('ImageDetails.CountryCodeISO','=',$_GET['countries']));
      } else if (isset($_GET['continent']) && $_GET['continent'] != "0" && !empty($_GET['continent']))   { 
        $statement = $db->findAllParam(array('ImageDetails.ContinentCode','=',$_GET['continent'])); 
      } else if (isset($_GET['cities']) && $_GET['cities'] != "0" && !empty($_GET['cities']))           { 
        $statement = $db->findAllParam(array('ImageDetails.CityCode','=',$_GET['cities']));
      } else if (isset($_GET['title']) && !empty($_GET['title']))                                     { 
        $statement = $db->findAllParam(array('ImageDetails.Title',' LIKE ','%'.$_GET['title'].'%'));
      } else if (isset($_GET['search'])) {
        $statement = $db->findAllParam(array('ImageDetails.Title', ' LIKE ', '%'.$_GET['search'].'%',
                                             ' OR ', 'ImageDetails.Description', ' LIKE ', '%'.$_GET['search'].'%'));
      }
    }
  } catch (PDOException $e) {
    die($e->getMessage());
  }
  return $statement;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Browse images</title>
    <?php include 'includes/stylesheets.inc.php';  ?>

</head>

<body>
    <?php include 'includes/header.inc.php'; ?>
    
    <!-- Page Content -->
    <main class="container">
      <h3>Images</h3>
        <div class="panel panel-default">
          
          <div class="panel-body">
            <h4>filters</h4>
            <form action="browse-Images.php" method="get" class="form-horizontal">
              
              <div class="form-inline">
              
              <?php outputDrop('continent', $connection); ?>
              <?php outputDrop('countries', $connection); ?>
              <?php outputDrop('cities', $connection); ?>
              
              <input type="text" placeholder="Search title" class="form-control" name="title">
              <button type="submit" class="btn btn-primary">Filter</button>
              <?php if (!empty($_GET['cities']) | !empty($_GET['countries']) | !empty($_GET['continent']) | !empty($_GET['title'])) { ?>
                <a href=<?php echo $_SERVER['PHP_SELF']; ?> role="button" class="btn btn-success">Reset</a>
              <?php   } ?>
              </div>
            </form>
          </div>
        </div>     
                                    
    <div class="panel panel-default">
            <div class="panel-body">
              <h4>results <?php echo getSearch(); ?></h4>
                <ul class="caption-style-2">
                    <?php 
                    try { 
                      $statement = outputImage($connection);
                      foreach ($statement as $row) { ?>
                        
                        <li>
                          <a href="single-image.php?imgID=<?php echo $row['ImageID']; ?>" class="img-responsive">
                          <img src="images/square-medium/<?php echo $row['Path']; ?>" alt="<?php echo $row['Title']; ?>">
                          <div class="caption">
                            <div class="blur"></div>
                            <div class="caption-text">
                              <p><?php echo $row['Title']; } ?></p>
                            </div>
                          </div>
                          </a>
                        </li>
                    <?php } catch (PDOException $e) {
                        die($e->getMessage());
                    } ?>
                </ul> 
            </div>
        </div>
    </div>
      
    </main>
    
        <?php include 'includes/footer.inc.php'; ?>


        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>

</html>
