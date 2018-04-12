<?php 
//SOURCE: http://php.net/manual/en/function.substr.php
function after ($this, $inthat) {
        if (!is_bool(strpos($inthat, $this)))
        return substr($inthat, strpos($inthat,$this)+strlen($this));
    };

function after_last ($this, $inthat) {
    if (!is_bool(strrevpos($inthat, $this)))
    return substr($inthat, strrevpos($inthat, $this)+strlen($this));
};

function before ($this, $inthat) {
    return substr($inthat, 0, strpos($inthat, $this));
};

function before_last ($this, $inthat) {
    return substr($inthat, 0, strrevpos($inthat, $this));
};

function between ($this, $that, $inthat) {
    return before ($that, after($this, $inthat));
};

function between_last ($this, $that, $inthat) {
 return after_last($this, before_last($that, $inthat));
};

// use strrevpos function in case your php version does not include it
function strrevpos($instr, $needle) {
    $rev_pos = strpos (strrev($instr), strrev($needle));
    if ($rev_pos===false) return false;
    else return strlen($instr) - $rev_pos - strlen($needle);
};

function makeLink($url, $text, $class, $value) {
    $html = "<a href=$url class=$class >$text</a>";
    return $html;
}

function makePanel($header, $content) {
    $html = "";
    $html .= "<div class='panel panel-default description'>";
    $html .= "<div class='panel-body'>";
    $html .= "<h4>$header</h4>";
    $html .= $content;
    $html .= "</div></div>";
    return $html;
}

function makeSelect($name, $value, $placeholder, $content) {
    $html .= "<select name=$name class='form-control'>";
    // change placeholder to currently active value if there is one
    if ($bool) {
        $html .= "<option value=$value selected>$placeholder</option>";
    } else {
        $html .= "<option value=$value>$placeholder</option>";
    }
    
    $html .= $content;
    $html .= "</select>";
    return $html;
} 

function makeImgOptions() {
    $html = '<div class="btn-group btn-group-justified" role="group" aria-label="...">';
    $html .= "<div class='btn-group' role='group'>
                <a href='img-favs.php?imgID=".$_GET['imgID']."' id='fav-button'><button type='submit' class='btn btn-default'><span class='glyphicon glyphicon-heart' aria-hidden='true'></span></button>
              </a></div>";
    $html .= "<div class='btn-group' role='group'>
                <a href='removeCookie.php?imgID=".$_GET['imgID']."'><button type='button' class='btn btn-default'><span class='glyphicon glyphicon-save' aria-hidden='true'></span></button>
              </a></div>";
    $html .= '<div class="btn-group" role="group">
                <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></button>
              </div>';
    $html .= '<div class="btn-group" role="group">
                <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span></button>
              </div>';
    $html .= '</div>';
    return $html; 
}

function makePostOptions() {
    $html = '<div class="btn-group btn-group-justified" role="group" aria-label="...">';
    $html .= "<div id='fav-button' class='btn-group' role='group'>
                <a href='post-favs.php?id=".$_GET['id']."'><button type='submit' class='btn btn-default'><span class='glyphicon glyphicon-heart' aria-hidden='true'></span></button>
              </a></div>";
    $html .= "<div class='btn-group' role='group'>
                <a href='removeCookie.php?id=".$_GET['id']."'><button type='button' class='btn btn-default'><span class='glyphicon glyphicon-save' aria-hidden='true'></span></button>
              </a></div>";
    $html .= '<div class="btn-group" role="group">
                <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></button>
              </div>';
    $html .= '<div class="btn-group" role="group">
                <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span></button>
              </div>';
    $html .= '</div>';
    return $html; 
}

function generateImages($connection) {
  try {
    $db = new ImageDetailsGateway($connection);
    
    if ($_SERVER['PHP_SELF'] == "/assignment1/single-country.php") {
        $statement = $db->findAllParam(array('CountryCodeISO','=',$_GET['id']));
    } else {
        $statement = $db->findAllParam(array('UserID','=',$_GET['id']));
    }
    
    foreach($statement as $row) {
        $html = "<a href='single-image.php?imgID=".$row['ImageID']."' >";
        $html .= "<img src='images/square-medium/".$row['Path']."' alt='".$row['Title']."' class='img-responsive' style='height: 100px; width: 100px; display: inline; margin: 0 10px 10px 0'>";
        $html .= "</a>";
        echo $html;
    } 
  } catch (PDOException $e) {
      die( $e->getMessage() );
    }
} 

function generatePosts($connection, $userid) {
  try {
    
    // get all posts by user  
    
    $imgDB = new ImageDetailsGateway($connection);
    echo "<ul class='nav nav-pills'>";
        $s2 = $imgDB->findAllJoin('PostImages', 'ImageID', null, array('PostImages.PostID','=',$_GET['id']));
        
        foreach ($s2 as $r) {
            $content = "<img src='images/square-medium/".$r['Path']."'" .
            "alt=".$r['Title'].
            " class='img-responsive' onmouseover=preview(this) onmouseout=hide(this)". 
            " style='height: 100px; width: 100px'>";
            
            $url = "single-image.php?imgID=".$r['ImageID'];
            
            $active = true;
            
            // if url matches did of content, it's active
            if ($active) {
                echo "<li role='presentation'>";
                echo "<a href=$url class='#'>$content</a>";
            } else {
                echo "<li role='presentation'>";
                echo "<a href=$url class='#'>$content</a>";
            }
            echo "</li>";
        }
        
    //}
    echo "</ul>";
  } catch (PDOException $e) {
      die( $e->getMessage() );
    }
} 
?>