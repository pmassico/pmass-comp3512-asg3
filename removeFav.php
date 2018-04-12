<?php
// get id of cookie to remove
// get favourites array
// iterate through array to find item
// delete from array

$toRemove = $_GET['id'];

$favourites = explode(",", $_COOKIE['img_favs']);

for ($i = 0; $i < sizeof($favourites); $i++) {
    // iterate through array
    if ($favourites[$i] == $toRemove) {
        // check if current item = removal item, then remove
        unset($favourites[$i]);
        // re-index
        $favourites = array_values($favourites);
    }
}

// re-set cookie
$favourites = implode(",", $favourites);
setCookie("img_favs", $favourites, $expiryTime);

header("Location: favourites.php");
?>