<?php 
include 'includes/dbFunctions.inc.php';
$expiryTime = time()+60*60*24;

// cookie is string, turn into array
// work with arrays inside cookie
// to save back to the cookie, turn back into string

// array functions
// string implode ( string $glue , array $pieces )
// array explode ( string $delimiter , string $string [, int $limit = PHP_INT_MAX ] )

if (!isset($_COOKIE['img_favs'])) {
    //cookie isn't set already
    $favourites[] = $_GET['imgID'];
} else if (isset($_COOKIE['img_favs'])) {
    // if it is set, retrieve current cookie and turn into array 
    $favourites = explode(",", $_COOKIE['img_favs']);
    
    // check if already inside
    $dup = false;
    foreach ($favourites as $i) {
        if ((int)$i == (int)$_GET['imgID']) {
            // if inside, set flag to true
            // if not inside, does not enter if -> flag isn't changed
            $dup = true;
        }
    }
    
    // if not in array add to array
    if ($dup == false) { $favourites[] = $_GET['imgID']; }
}

//since we can't append something to a cookie, we'll just overwrite the
// current one with the updated $favourites list
if ($dup == false) {
    if (validImgID($_GET['imgID'])) {
        //turn array back into string
        $favourites = implode(",", $favourites);
        setCookie("img_favs", $favourites, $expiryTime);
    }
}

header("Location: single-image.php?imgID=".$_GET['imgID']);
?>