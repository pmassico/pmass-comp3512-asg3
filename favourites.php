<?php
include 'includes/dbFunctions.inc.php';
include 'includes/markupFunctions.inc.php';
include 'config.php';

function outputFavImages($connection) {
    if (isset($_COOKIE['img_favs'])) {
        //turn contents into an array
        $favList = explode(",", $_COOKIE['img_favs']);
        
        try {
            $db = new ImageDetailsGateway($connection);
            
            $html = "<div class='list-group fav'>";
            //for each item in the array, make a favourites list item
            foreach ($favList as $imgID) {
                $statement = $db->findAllParam(array('ImageID','=',$imgID));
                $row = $statement[0];
                $html .= "<a href='single-image.php?imgID=".$imgID."' class='fav block list-group-item' >".
                         "<img class='block img-responsive' src=images/square-small/".$row['Path']." alt=".$row['Title']."> ".
                         $row['Title'].
                         "</a>".
                         "<a href='removeFav.php?id=".$imgID."'><span class='block glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
            }
            $html .= "</div>"; 
            return $html;
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    } else {
        echo "<div class='alert' role='alert'>You have no favourites.</div>";
    }
}

function outputFavPosts($connection) {
    if (isset($_COOKIE['post_favs'])) {
        //turn contents into an array
        $favList = explode(",", $_COOKIE['post_favs']);
        
        try {
            $db = new PostsGateway($connection);
            
            $html = "<div class='list-group fav'>";
            //for each item in the array, make a favourites list item
            foreach ($favList as $postID) {
                $statement = $db->findAllParam(array('PostID','=',$postID));
                $post = $statement[0];
                
                $db3 = new ImageDetailsGateway($connection);
                $statement3 = $db3->findAllParam(array('ImageID','=',$post['MainPostImage']));
                $row = $statement3[0];
                
                $html .= "<a href='single-post.php?id=".$postID."' class='fav block list-group-item' >".
                         "<img class='block img-responsive' src=images/square-small/".$row['Path']." alt=".$row['Title']."> ".
                         $row['Title'].
                         "</a>".
                         "<a href='removePostFav.php?id=".$postID."'><span class='block glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
            }
            $html .= "</div>"; 
            return $html;
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    } else {
        echo "<div class='alert' role='alert'>You have no favourites.</div>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Favourites</title>
    <?php include 'includes/stylesheets.inc.php'; ?>
</head>
<body>
    <?php include 'includes/header.inc.php'; ?>
    
    <main class="container">
        <div class='row'>
            <h2>Favourites</h2>
            <button type='button' class='btn btn-default' id='print' data-toggle='modal' data-target='#myModal'>Print Favourites</button>
        </div>
        <div class='row'>
            <div class="panel panel-default col-md-6">
                <h3>images <a href='clearFavCookie.php'><button type='button' class='btn btn-default'>Clear</button></a></h3>

                <?php echo outputFavImages($connection); ?>
                
            </div>
            <div class="panel panel-default col-md-6">
                <h3>posts <a href='clearPostFavCookie.php'><button type='button' class='btn btn-default'>Clear</button></a></h3>
                
                <?php echo outputFavPosts($connection); ?>
                
            </div>
        </div>
        
        <!--Print Favourites-->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Print Favourites</h1>
                    </div>
                    <div class="modal-body">
                        <!--for each image in favourites: display image, select print size, quantity, paper stock, frame-->
                        <?php
                        if (isset($_COOKIE['img_favs'])) {
                            $favList = explode(",", $_COOKIE['img_favs']);
                            $favNum = 0; //determines number on querystring ids
                            
                                try {
                                    $db = new ImageDetailsGateway($connection);
                                    
                                    // $html = "<div class='list-group fav col-md-8'>";
                        ?>
                            <form method="post" class="table-responsive" id="printForm">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Size</th>
                                            <th>Paper</th>
                                            <th>Frame</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="favTable">
                        <?php
                                    //for each item in the array, make a favourites list item
                                    foreach ($favList as $imgID) {
                                        $favNum++;
                                        $statement = $db->findAllParam(array('ImageID','=',$imgID));
                                        $row = $statement[0];
                        ?>
                        <tr>
                        
                            <!--image-->
                            <td><img src="images/square-small/<?php echo $row['Path']; ?>" alt="<?php echo $row['Title']; ?>" id="printImg<?php echo $favNum; ?>"></td>
                            <!--print size option-->
                            <td><select id="size<?php echo $favNum; ?>" class="print-select size-list"></select></td>
                            <!--paper stock option-->
                            <td><select id="paper<?php echo $favNum; ?>" class="print-select paper-list"></select></td>
                            <!--frame option-->
                            <td><select id="frame<?php echo $favNum; ?>" class="print-select frame-list"></select></td>
                            <!--quantity-->
                            <td><input type="text" id="qty<?php echo $favNum; ?>" class="print-select qty" value=1 /></td>
                            <!--line total-->
                            <td id="lineTotal<?php echo $favNum; ?>">$<span id="lineTotalAmt<?php echo $favNum; ?>">0</span></td>
                            
                        </tr>
                        <?php
                                    
                                    }
                                } catch(PDOException $e) {
                                    die($e->getMessage());
                                }
                        ?>
                        
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan=4></td>
                            <td>Subtotal</td>
                            <td id="subTotal">$<span id="subTotalAmt">0</span></td>
                        </tr>
                        <tr>
                            <td colspan=3></td>
                            <td><span id="shippingOptions"></span></td>
                            <td>Shipping</td>
                            <td id="shippingTotal">$<span id="shippingTotalAmt">0</span></td>
                        </tr>
                        <tr>
                            <td colspan=4></td>
                            <td>Grand Total</td>
                            <td id="grandTotal">$<span id="grandTotalAmt">0</span></td>
                        </tr>
                        <tr>
                            <td colspan=5></td>
                            <td><button type="submit" class="btn btn-primary" id="order">Order</button></td>
                        </tr>
                        </tfoot>
                        
                        </table>
                        
                        </form>
                        
                        <?php
                        } else {
                            echo "<div class='alert' role='alert'>Oops! Looks like you don't have any image favourites.</div>";
                        }
                        ?>
                        
                    </div>
                </div>
            </div>
        </div>
        
    </main>
    
    <script src='js/favourite_js.js'></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>