<?php 
unset($_COOKIE['img_favs']);

setCookie("img_favs", "", -1);

header("Location: favourites.php");
?>