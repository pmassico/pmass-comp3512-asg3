<?php
include 'includes/dbFunctions.inc.php'; 
include 'includes/markupFunctions.inc.php';
require_once('config.php');

function previousPage() {
    //spits out a <li> for the previous page
    
    $previous = (int)$_GET['page']-1;
    
    if ((int)$_GET['page']==1) { 
        $html = "<li class='page-item disabled'>
                    <span class='page-link'>Previous</span>
                </li>";
        
    } else {  
        $html = "<li class='page-item'><a class='page-link' href='browse-Posts.php?page=$previous'>Previous</a></li>";
    }
    
    
    return $html;
}

function nextPage() {
    //spits out a <li> for the previous page
    
    $next = (int)$_GET['page']+1;
    
    if ((int)$_GET['page']==10) { 
        $html = "<li class='page-item disabled'>
                    <span class='page-link'>Next</span>
                </li>";
        
    } else {  
        $html = "<li class='page-item'><a class='page-link' href='browse-Posts.php?page=$next'>Next</a></li>";
    }
    
    
    return $html;
}

function pagination() {
    
    echo "<nav><ul class='pagination'>";
    echo previousPage();
    $next = (int)$_GET['page']+1;
    
    for ($i=1;$i<=10;$i++) {
        // if page= li about to be spit out, make active
        if ((int)$_GET['page']==$i) {
          $active = "active";
        } else {
          $active = "";
        }
      
        echo "<li class='page-item $active'><a class='page-link' href='browse-Posts.php?page=$i'>$i</a></li>";
    }
                      
    echo nextPage();
                    
    echo "</ul></nav>";
};

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Browse posts</title>
    <?php include 'includes/stylesheets.inc.php'; ?>
</head>

<body>
    <?php include 'includes/header.inc.php'; ?>
    
    <main class="container">
        <div class="row">
            <?php include "includes/left.inc.php"; ?>
            
            <div class="col-md-10">

                <div class="jumbotron" id="postJumbo">
                    <h2>Posts</h2>
                    <p>Read other travellers' posts ... or create your own. 
                    <a class="btn btn-warning">Learn more &raquo;</a></p>
                </div>
                <?php pagination(); ?>
                
                 <div class="postlist">

                   <?php
                   // TODO: show first 5
                   $db = new PostsGateway($connection);
                   $s1 = $db->findAll();
                   
                   // turn this into a join?
                   $db2 = new UsersGateway($connection);
                   
                   $db3 = new PostImagesGateway($connection);
                   
                   $db4 = new ImageDetailsGateway($connection);
                   
                   // p1, 0 - 3
                   // min = 0+(page#-1*4);
                   // max = 3+(page#-1*4); 
                   
                   // p2, 4 - 7
                   // min = min+(page#-1*4);
                   // max = max+(page#-1*4); 
                   
                   // min OR max, + (page#-1*4) // page 1, 1-1*4 = 0. page 2, 2-1*4 = 4
                   $min = 0+(((int)$_GET['page']-1)*3);
                   $max = 3+(((int)$_GET['page']-1)*3);
                   
                   // imageID changes to postID which maps to an imageID
                   // PATH takes that mapping and grabs the path
                   for ($i=$min;$i<$max;$i++) {
                       
                        try {
                            $postRow = $s1[$i];
                            $s2 = $db2->findById($postRow['UserID']);
                            $s3 = $db3->findById($postRow['PostID']);
                            $s4 = $db4->findById($postRow['MainPostImage']);
                           
                            $message = substr($postRow['Message'], 0, 160);
                            $message .= " ...";
                           
                            echo "<div class='row'>
                               <div class='col-md-4'> 
                                  <a href='single-post.php?id=".$s3['ImageID']."' class=''><img src='images/medium/".$s4['Path']."' alt=".$postRow['Title']." class='img-responsive'/></a>
                               </div>
                               <div class='col-md-8'> 
                                  <h3>".$postRow['Title']."</h3>
                                  <div class='details'>
                                    Posted by <a href='user.php?id=".$postRow['UserID']."'>".$s2['FirstName']." ".$s2['LastName']."</a>
                                    <span class='pull-right'>".substr($postRow['PostTime'],0,10)."</span> 
                                  </div>
                                  <p class='excerpt'>".$message."</p>
                                  <p class='pull-right'><a href='single-post.php?id=".$postRow['PostID']."' class='btn btn-primary btn-sm'>Read more</a></p>
                               </div>
                            </div>
                            <hr>";
                       
                           } catch (PDOException $e) {
                               //do nothing
                           } 
                               
                        }
                       
                    
                   ?>
                   <!-- /.row -->
                   
                                          
                 </div>   <!-- end postlist -->         
                 <?php pagination(); ?>
            </div>  <!-- end col-md-10 -->
        </div>   <!-- end row -->
    </main>
    
        <?php include 'includes/footer.inc.php'; ?>


        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>

</html>
